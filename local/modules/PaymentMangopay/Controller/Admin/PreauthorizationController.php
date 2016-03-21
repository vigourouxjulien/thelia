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

namespace PaymentMangopay\Controller\Admin;

use PaymentMangopay\Form\ConfigurationForm;
use PaymentMangopay\Model\MangopayConfigurationQuery;
use PaymentMangopay\Model\OrderPreauthorisationQuery;
use PaymentMangopay\PaymentMangopay;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Model\OrderProductQuery;
use Thelia\Model\OrderQuery;
use Thelia\Model\OrderStatus;
use Thelia\Model\OrderStatusQuery;

class PreauthorizationController extends BaseAdminController
{

    public function preauthorizationView($preauthorization_id,$order_id){
        return $this->render('modal-preauthorization-view',array('preauthorization_id'=>$preauthorization_id,'order_id'=>$order_id));
    }

    public function preauthorizationPayIn($preauthorization_id,$order_id)
    {

        $api = PaymentMangopay::getMangoPayApi();
        $MyPreauthorization = $api->CardPreAuthorizations->Get($preauthorization_id);
        //check if preauth is 'succeeded' and 'wainting'
        if ($MyPreauthorization->Status === 'SUCCEEDED' && $MyPreauthorization->PaymentStatus === 'WAITING') {

            $myOrder = OrderQuery::create()->findPk($order_id);

            //check the orderStatus, must be "not paid"
            if($myOrder->getStatusId() == OrderStatusQuery::getNotPaidStatus()->getId()){

                //Some product can be deleted from order
                $orderProductDelete = $this->getRequest()->get('orderproduct');
                if($orderProductDelete && is_array($orderProductDelete)){
                    foreach($orderProductDelete as $item){
                        $myOrderProduct = OrderProductQuery::create()->findPk($item);
                        if($myOrderProduct){
                            $myOrderProduct->delete();
                        }
                    }
                }

                $orderAmount = $myOrder->getTotalAmount();

                $preAuthAmount = $MyPreauthorization->DebitedFunds->Amount;

                //The orderAmount must be less or equale to the preAuthAmount
                if($orderAmount<=$preAuthAmount){

                    $txFees = PaymentMangopay::getFees();
                    $fees = $orderAmount * ($txFees/100);

                    $PayIn = new \MangoPay\PayIn();
                    $PayIn->CreditedWalletId = PaymentMangopay::getTestWallet();
                    $PayIn->AuthorId = PaymentMangopay::getTestUser();
                    $PayIn->PaymentType = "CARD";
                    $PayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsPreAuthorized();
                    $PayIn->PaymentDetails->PreauthorizationId = $MyPreauthorization->Id;
                    $PayIn->DebitedFunds = new \MangoPay\Money();
                    $PayIn->DebitedFunds->Currency = "EUR";
                    $PayIn->DebitedFunds->Amount = $orderAmount;
                    $PayIn->Fees = new \MangoPay\Money();
                    $PayIn->Fees->Currency = "EUR";
                    $PayIn->Fees->Amount = $fees;
                    $PayIn->ExecutionType = "DIRECT";
                    $PayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
                    $myPayIn = $api->PayIns->Create($PayIn);

                    if($myPayIn->Status === 'SUCCEEDED'){

                        //Validate the preauth in DB
                        $myPreauthDb = OrderPreauthorisationQuery::create()->findPk(array($order_id,$preauthorization_id));
                        $myPreauthDb->setStatus('VALIDATED')
                            ->save();

                        $myOrder->setTransactionRef($myPayIn->Id)
                            ->save();

                        // Set order status as PAID
                        $event = new OrderEvent($myOrder);
                        $event->setStatus(OrderStatusQuery::create()->findOneByCode(OrderStatus::CODE_PAID)->getId());
                        $this->dispatch(TheliaEvents::ORDER_UPDATE_STATUS,$event);

                    }

                }
            }

        }

        // Set the module router to use module routes
        $this->setCurrentRouter("router.paymentmangopay");
        return $this->generateRedirectFromRoute("paymentmangopay.payins");

    }
}