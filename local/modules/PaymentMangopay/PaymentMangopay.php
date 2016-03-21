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

namespace PaymentMangopay;

use PaymentMangopay\Model\Base\MangopayConfigurationQuery;
use PaymentMangopay\Model\MangopayConfiguration;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Core\HttpFoundation\Session\Session;
use Thelia\Install\Database;

use Thelia\Core\HttpFoundation\Response;
use Symfony\Component\Routing\Router;
use Thelia\Module\BaseModule;
use Thelia\Module\PaymentModuleInterface;
use Thelia\Model\Order;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Module\AbstractPaymentModule;
use Thelia\Tools\URL;

use MangoPay\MangoPayApi;
use MangoPay\PayIn;
use MangoPay\PayInExecutionDetailsWeb;
use MangoPay\PayInPaymentDetailsCard;
use MangoPay\Libraries\ResponseException;
use MangoPay\Libraries\Exception;
use MangoPay\Libraries\Logs;

class PaymentMangopay extends AbstractPaymentModule
{
    /** @var string */
    const DOMAIN_NAME = 'paymentmangopay';
    const BO_DOMAIN_NAME = 'paymentmangopay.bo.default';

    static function getTestUser(){
        return 11463819;
    }
    static function getTestWallet(){
        return 11463820;
    }

    static function getFees(){
        $configValues = MangopayConfigurationQuery::create()->findPk(1);
        return $configValues->getFees();
    }
    static function getDeferredPay(){
        $configValues = MangopayConfigurationQuery::create()->findPk(1);
        return $configValues->getDeferredPayment();
    }

    public function postActivation(ConnectionInterface $con = null)
    {
        /*
         * Default test values
         * Fees : 10
         * Client Id : juvigouroux
         * Client Password : vtS5TEC0KyvWnzR9DRtGJAuqDRNbQBH2opp4PMMGzTNZinqeKC
         * Temporary Folder : writablefolder
         *
         * ---------------------------------
         * Client Id : juvigouroux2
         * Client Password : S97gRG4GcwopSCMNZBrF2kjJto7XcRvntr9zaTX8JuMSvzkqFg
         *
         */
        $database = new Database($con);
        $database->insertSql(null, array(__DIR__ . '/Config/thelia.sql'));

        $config = new MangopayConfiguration();
        $config->setFees(0)
            ->setClientid("")
            ->setClientpassword("")
            ->setTemporaryfolder("")
            ->setDeferredPayment(0)
            ->setDays(0)
            ->save();

    }

    static function getMangoPayApi()
    {
        $configValues = MangopayConfigurationQuery::create()->findPk(1);
        if($configValues->getClientid()!=""){
            $api = new MangoPayApi();
            $api->Config->ClientId = $configValues->getClientid();
            $api->Config->ClientPassword = $configValues->getClientpassword();
            $api->Config->TemporaryFolder = THELIA_WEB_DIR.$configValues->getTemporaryfolder();
            return $api;
        }
        return null;
        /*
        $api->Config->ClientId = 'juvigouroux';
        $api->Config->ClientPassword = 'vtS5TEC0KyvWnzR9DRtGJAuqDRNbQBH2opp4PMMGzTNZinqeKC';
        $api->Config->TemporaryFolder = THELIA_WEB_DIR.'/writablefolder';
        */
    }
    /*
    static function getConfigValue($field,$defaultValue){
        $configValues = MangopayConfigurationQuery::create()->findPk(1);
    }
    */

    /*
     * You may now override BaseModuleInterface methods, such as:
     * install, destroy, preActivation, postActivation, preDeactivation, postDeactivation
     *
     * Have fun !
     */

    public function isValidPayment()
    {
        return true;
    }

    public function pay(Order $order)
    {
        if(PaymentMangopay::getDeferredPay() == 1){
            $this->doDeferredPay($order);
        }
        else{
            $this->doDirectPay($order);
        }
    }
    public function doDirectPay(Order $order)
    {
        try {

            $Amount = $order->getTotalAmount();
            $Fees = $Amount * 0.1;

            $returnUrl = $this->getPaymentSuccessPageUrl($order->getId());

            //Récupération des données du vendeur
            $user = PaymentMangopay::getTestUser();
            $wallet = PaymentMangopay::getTestWallet();

            //Récupératin du type de carte à utiliser
            //CB_VISA_MASTERCARD MAESTRO DINERS P24 IDEAL BCMC MASTERPASS
            $cardType = "CB_VISA_MASTERCARD";

            //Récupération du langage courrant
            $session = new Session();
            $defaultLang = $session->getLang()->getLocale();

            $executionDate = new \DateTime(date('Y/m/d'));

            $api = PaymentMangopay::getMangoPayApi();
            $PayIn = new PayIn();
            $PayIn->CreditedWalletId = $wallet;
            $PayIn->AuthorId = $user;
            $PayIn->PaymentType = "CARD";
            $PayIn->PaymentDetails = new PayInPaymentDetailsCard();
            $PayIn->PaymentDetails->CardType = $cardType;
            $PayIn->DebitedFunds = new \MangoPay\Money();
            $PayIn->DebitedFunds->Currency = "EUR";
            $PayIn->DebitedFunds->Amount = $Amount;
            $PayIn->Fees = new \MangoPay\Money();
            $PayIn->Fees->Currency = "EUR";
            $PayIn->Fees->Amount = $Fees;
            $PayIn->ExecutionType = "WEB";
            $PayIn->ExecutionDetails = new PayInExecutionDetailsWeb();
            $PayIn->ExecutionDetails->ReturnURL = $returnUrl;

            $PayIn->ExecutionDetails->Culture = strtoupper($defaultLang);
            $PayIn->ExecutionDate = $executionDate->getTimestamp();
            $result = $api->PayIns->Create($PayIn);

            $transaction_id = $result->Id;
            $order->setTransactionRef($transaction_id)->save();

            $html_params = array();

            return $this->generateGatewayFormResponse($order, $result->ExecutionDetails->RedirectURL, $html_params);
        } catch (ResponseException $e) {

            Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
            Logs::Debug('Message', $e->GetMessage());
            Logs::Debug('Details', $e->GetErrorDetails());

        } catch (Exception $e) {

            Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
        }
    }
    public function doDeferredPay(Order $order)
    {
        try {
            $Amount = $order->getTotalAmount();
            $Fees = $Amount * 0.1;

            //Création d'une carte de paiement
            $api = PaymentMangopay::getMangoPayApi();

            $user = PaymentMangopay::getTestUser();
            $wallet = PaymentMangopay::getTestWallet();

            $cardRegister = new \MangoPay\CardRegistration();
            $cardRegister->UserId = $user;
            $cardRegister->Currency = "EUR";
            $result = $api->CardRegistrations->Create($cardRegister);

            //$returnUrl = $_SERVER["HTTP_HOST"].'/mangopay/'.$order->getId().'/registercard?CardReg='.$result->Id.'&user='.$user.'&wallet='.$wallet.'&amount='.$Amount;
            /*
            $MangopayRouter = $this->getContainer()->get('router.paymentmangopay');

            $returnUrl = URL::getInstance()->absoluteUrl(
                $MangopayRouter->generate(
                    "paymentmangopay.fillcard",
                    array(
                        "order_id" => $order->getId(),
                        "data" => $result->PreregistrationData,
                        "accessKeyRef" => $result->AccessKey,
                        "returnURL" => $returnUrl
                    ),
                    Router::ABSOLUTE_URL
                )
            );

            Redirect::exec($returnUrl);
            */
            //$parser = $this->getContainer()->get("thelia.parser");


            $parser = $this->getContainer()->get("thelia.parser");

            $parser->setTemplateDefinition(
                $parser->getTemplateHelper()->getActiveFrontTemplate()
            );
            var_dump($result);
            $renderedTemplate = $parser->render(
                "card-register-mangopay.html",
                array(
                    "order_id" => $order->getId(),
                    "data" => $result->PreregistrationData,
                    "accessKeyRef" => $result->AccessKey,
                    "CardReg" => $result->Id,
                    "user" => $user,
                    "wallet" => $wallet,
                    "amount" => $Amount
                    //"returnURL" => $returnUrl
                )
            );

            return Response::create($renderedTemplate);


            //return $this->generateGatewayFormResponse($order, $result->ExecutionDetails->RedirectURL, $html_params);
            /*
            return $this->render(
                'card-register-mangopay',
                array(
                    "order_id" => $order->getId(),
                    "data" => $result->PreregistrationData,
                    "accessKeyRef" => $result->AccessKey,
                    "returnURL" => $returnUrl
                )
            );
            */


            /*$returnUrl = $this->retrieveUrlFromRouteId(
                'order.placed',
                array('order_id'=>$order->getId()),
                array()
            );*/
            //$this->setCurrentRouter("router.paymentmangopay");


            /*
            $MangopayRouter = $this->getContainer()->get('router.paymentmangopay');

            $returnUrl = URL::getInstance()->absoluteUrl(
                $MangopayRouter->generate(
                    "paymentmangopay.confirmation",
                    array("order_id" => $order->getId()),
                    Router::ABSOLUTE_URL
                )
            );
            //$returnUrl = $this->getPaymentSuccessPageUrl($order->getId());

            $executionDate = new \DateTime('2016/03/16');

            $api = PaymentMangopay::getMangoPayApi();
            $PayIn = new PayIn();
            $PayIn->CreditedWalletId = 11308215;
            $PayIn->AuthorId = 11308049;
            $PayIn->PaymentType = "CARD";
            $PayIn->PaymentDetails = new PayInPaymentDetailsCard();
            $PayIn->PaymentDetails->CardType = "CB_VISA_MASTERCARD";
            $PayIn->DebitedFunds = new \MangoPay\Money();
            $PayIn->DebitedFunds->Currency = "EUR";
            $PayIn->DebitedFunds->Amount = $Amount;
            $PayIn->Fees = new \MangoPay\Money();
            $PayIn->Fees->Currency = "EUR";
            $PayIn->Fees->Amount = $Fees;
            $PayIn->ExecutionType = "WEB";
            $PayIn->ExecutionDetails = new PayInExecutionDetailsWeb();
            $PayIn->ExecutionDetails->ReturnURL = $returnUrl;
            $PayIn->ExecutionDetails->Culture = "EN";
            $PayIn->ExecutionDate = $executionDate->getTimestamp();
            $result = $api->PayIns->Create($PayIn);

            $transaction_id = $result->Id;
            $order->setTransactionRef($transaction_id)->save();

            $html_params = array();

            return $this->generateGatewayFormResponse($order, $result->ExecutionDetails->RedirectURL, $html_params);
            */
        } catch (ResponseException $e) {

            Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
            Logs::Debug('Message', $e->GetMessage());
            Logs::Debug('Details', $e->GetErrorDetails());

        } catch (Exception $e) {

            Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
        }
    }

    public function manageStockOnCreation()
    {
        return false;
    }
}
