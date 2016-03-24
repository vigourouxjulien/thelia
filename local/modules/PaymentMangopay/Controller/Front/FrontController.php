<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace PaymentMangopay\Controller\Front;

use PaymentMangopay\Event\MangopayDispatchPaymentEvent;
use PaymentMangopay\Event\PaymentMangopayEvents;
use PaymentMangopay\Model\OrderPreauthorisation;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use PaymentMangopay\PaymentMangopay;
use Thelia\Model\OrderQuery;
use Thelia\Model\OrderStatus;
use Thelia\Model\OrderStatusQuery;
use MangoPay\Libraries\ResponseException;
use MangoPay\Libraries\Exception;
use MangoPay\Libraries\Logs;

class FrontController extends BaseFrontController
{
    public function fillCard($order_id){
        return $this->generateRedirectFromRoute(
            "order.placed",
            array(),
            array("order_id" => $order_id)
        );
    }
    public function registerCardSuccess($order_id){
         return $this->render('card-register-success');
    }
    public function registerCard($order_id){

        try {
            $CardReg = $this->getRequest()->get('CardReg');
            $user = $this->getRequest()->get('user');
            $amount = $this->getRequest()->get('amount');
            $data = $this->getRequest()->get('data');
            $errorCode = $this->getRequest()->get('errorCode');

            $api = PaymentMangopay::getMangoPayApi();
            $cardRegisterPut = $api->CardRegistrations->Get($CardReg);
            $cardRegisterPut->RegistrationData = isset($_GET['data']) ? 'data=' . $_GET['data'] : 'errorCode=' . $_GET['errorCode'];
            $cardRegisterPut->RegistrationData = isset($data) ? 'data=' . $data : 'errorCode=' . $errorCode;
            $result = $api->CardRegistrations->Update($cardRegisterPut);
            //var_dump($cardRegisterPut);
            //var_dump($result);

            $order = OrderQuery::create()->findPk($order_id);

            if($result->Status === 'VALIDATED'){

                $this->setCurrentRouter('router.paymentmangopay');

                $SecureModeReturnURL = $this->retrieveUrlFromRouteId(
                    'paymentmangopay.registercardsuccess',
                    array(),
                    array('order_id'=>$order_id)
                );

                //Currency
                $currency = $order->getCurrency()->getCode();

                $CardPreAuthorization = new \MangoPay\CardPreAuthorization();
                $CardPreAuthorization->AuthorId = $user;
                $CardPreAuthorization->DebitedFunds = new \MangoPay\Money();
                $CardPreAuthorization->DebitedFunds->Currency = $currency;
                $CardPreAuthorization->DebitedFunds->Amount = $amount;
                $CardPreAuthorization->SecureMode = "DEFAULT";
                //$CardPreAuthorization->CardId = $cardRegisterPut->CardId;
                $CardPreAuthorization->CardId = $result->CardId;
                //$CardPreAuthorization->SecureModeReturnURL = "http".(isset($_SERVER['HTTPS']) ? "s" : null)."://".$_SERVER["HTTP_HOST"]."/mangopay/demos/register_card_finish.php?user=".$user."&CardReg=".$CardReg;
                $CardPreAuthorization->SecureModeReturnURL = $SecureModeReturnURL;

                $cardPreAuth = $api->CardPreAuthorizations->Create($CardPreAuthorization);

                if($cardPreAuth->Status === 'CREATED'){

                    //Le paiement est autorisé et en attente
                    $preAuth = new OrderPreauthorisation();
                    $preAuth
                        ->setOrderId($order_id)
                        ->setPreauthorization($cardPreAuth->Id)
                        ->setStatus('WAITING')
                        ->save();
                    ;
                    //Retrieve the order by id
                    $order = OrderQuery::Create()->FindPk($order_id);
                    $event = new OrderEvent($order);
                    $this->getDispatcher()->dispatch(TheliaEvents::ORDER_CART_CLEAR, $event);
                    $this->setCurrentRouter('router.front');
                    //return $this->render('card-register-success',array('authnumber'=>$cardPreAuth->Id));

                    return $this->generateRedirectFromRoute(
                        "order.placed",
                        array("authnumber"=>$cardPreAuth->Id),
                        array("order_id" => $order_id)
                    );

                }
            }
            $this->setCurrentRouter('router.front');
            //return $this->render('card-register-fail');
            return $this->generateRedirectFromRoute(
                "order.failed",
                array(),
                array("order_id" => $order_id, "message" => "Erreur de paiement")
            );


        } catch (ResponseException $e) {

            Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
            Logs::Debug('Message', $e->GetMessage());
            Logs::Debug('Details', $e->GetErrorDetails());

        } catch (Exception $e) {

            Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
        }

    }

    /**
     * Method used when an payment is accepeted
     *
     * @param  string $hash hash to retrieve order
     *
     * @throws \Exception
     *
     * @return \Thelia\Core\HttpFoundation\Response
     */
    public function placedAction($order_id)
    {
        $order = null;

        $transactionId = $_REQUEST['transactionId'];

        //$transactionId must be a positive integer
        if ($transactionId > 0) {

            $api = PaymentMangopay::getMangoPayApi();
            $result = $api->PayIns->Get($transactionId);

            //Retrieve the order by id
            $order = OrderQuery::Create()->FindPk($order_id);

            //Check if transactionId match with order transaction_ref
            if($order && $transactionId == $order->getTransactionRef()){
                //Check the status of transaction
                if($result->Status === 'SUCCEEDED'){

                    // Verify if we can trust the transaction
                    if($order->getStatusId() !== OrderStatusQuery::create()->findOneByCode(OrderStatus::CODE_NOT_PAID)->getId())
                    {
                        throw new \Exception("This order was already been paid: " . $order->getStatusId());
                    }

                    // Set order status as PAID
                    $event = new OrderEvent($order);
                    $event->setStatus(OrderStatusQuery::create()->findOneByCode(OrderStatus::CODE_PAID)->getId());
                    $this->dispatch(TheliaEvents::ORDER_UPDATE_STATUS,$event);

                    $mangopay = new PaymentMangopay();

                    if ($event->getOrder()->isPaid() && $mangopay->isPaymentModuleFor($event->getOrder())) {

                        //Total ttc ?
                        $myOrder = $event->getOrder();

                        $transactionRef = $myOrder->getTransactionRef();
                        $currency = $myOrder->getCurrency()->getCode();
                        $dispatchPaymentEvent = new MangopayDispatchPaymentEvent($myOrder);

                        $this->dispatch(PaymentMangopayEvents::PAYMENT_MANGOPAY_DISPATCH,$dispatchPaymentEvent);
                        $tabTransfer = $dispatchPaymentEvent->getTabDispatch();
                        if(is_array($tabTransfer)){
                            foreach($tabTransfer as $aTransfer){
                                PaymentMangopay::doTransfer($transactionRef,$aTransfer['amount'],$order->getRef(),$aTransfer['user'],$aTransfer['wallet'],$currency);
                            }
                        }
                    }

                    //$order->setStatusId(OrderStatusQuery::getPaidStatus()->getId())->save();
                    return $this->generateRedirectFromRoute(
                        "order.placed",
                        array(),
                        array("order_id" => $order_id)
                    );
                }
            }
            else{
                throw new \Exception("We are unable to retrieve your order.");
            }

        }
    }
}