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

use MangoPay\Money;
use MangoPay\Transfer;
use PaymentMangopay\Model\Base\MangopayConfigurationQuery;
use PaymentMangopay\Model\MangopayConfiguration;
use PaymentMangopay\Model\MangopayEscrowwallet;
use PaymentMangopay\Model\MangopayOrderTransfert;
use PaymentMangopay\Model\MangopayWalletQuery;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Core\HttpFoundation\Session\Session;
use Thelia\Install\Database;

use Thelia\Core\HttpFoundation\Response;
use Symfony\Component\Routing\Router;
use Thelia\Log\Tlog;
use Thelia\Module\BaseModule;
use Thelia\Module\PaymentModuleInterface;
use Thelia\Model\Order;
use Thelia\Model\Lang;
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


use Thelia\Core\Template\ParserInterface;
use Thelia\Core\Template\TemplateHelperInterface;


class PaymentMangopay extends AbstractPaymentModule
{
    /** @var string */
    const DOMAIN_NAME = 'paymentmangopay';
    const BO_DOMAIN_NAME = 'paymentmangopay.bo.default';

    static function getTestUser(){
        //return 11463819;
        $configValues = MangopayWalletQuery::create()->filterByIsDefault(1)->findOne();
        return $configValues->getUser();
    }
    static function getTestWallet(){
        //return 11463820;
        $configValues = MangopayWalletQuery::create()->filterByIsDefault(1)->findOne();
        return $configValues->getWallet();
    }

    static function getEscrowUser(){
        //return 11463819;
        $configValues = MangopayWalletQuery::create()->filterByIsDefault(1)->findOne();
        return $configValues->getUser();
    }
    static function getEscrowWallet(){
        //return 11463820;
        $configValues = MangopayWalletQuery::create()->filterByIsDefault(1)->findOne();
        return $configValues->getWallet();
    }

    static function getFees(){
        $configValues = MangopayConfigurationQuery::create()->findPk(1);
        return $configValues->getFees();
    }
    static function getDeferredPay(){
        $configValues = MangopayConfigurationQuery::create()->findPk(1);
        return $configValues->getDeferredPayment();
    }
    /*
     * Return an array for split the payment
     * @params Order $order
     * @return array
     */
    /*
    static function getTabTransfer(Order $order){

        $amout = $order->getTotalAmount();
        $transferDebitedAmount = $amout / 2;

        $tabReturn = array();
        $tabReturn[] = array(
            'amount' => $transferDebitedAmount,
            'user' => 11460979,
            'wallet' =>11460981
        );
        $tabReturn[] = array(
            'amount' => $transferDebitedAmount,
            'user' => 11463819,
            'wallet' =>11463820
        );

        return $tabReturn;
    }
    */
    /*
     * Do a transfer from escrow wallet to user wallet for dispatch payment
     */
    static function doTransfer($transactionRef,$transferDebitedAmount,$orderRef,$creditedUserId,$creditedWalletId,$currency){

        $api = PaymentMangopay::getMangoPayApi();

        $escrowUser = PaymentMangopay::getEscrowUser();
        $escrowWallet = PaymentMangopay::getEscrowWallet();

        //DebitedFunds – Fees = CreditedFunds (amount received on wallet)
        $feesTx = PaymentMangopay::getFees();

        //Amount in cents
        $transferDebitedAmount = $transferDebitedAmount * 100;

        $transferFeesAmount = $transferDebitedAmount * ($feesTx/100);
        $transferCreditedAmount = $transferDebitedAmount - $transferFeesAmount;

        $transfer = new Transfer();
        $transfer->Tag = 'Tranfer for order '.$orderRef;
        $transfer->AuthorId = $escrowUser;
        $transfer->CreditedUserId = $creditedUserId;
        $transfer->DebitedWalletId = $escrowWallet;
        $transfer->CreditedWalletId = $creditedWalletId;

        $debitedFunds = new Money();
        $debitedFunds->Amount = $transferDebitedAmount;
        $debitedFunds->Currency = $currency;

        $fees = new Money();
        $fees->Amount = $transferFeesAmount;
        $fees->Currency = $currency;

        $creditedFunds = new Money();
        $creditedFunds->Amount = $transferCreditedAmount;
        $creditedFunds->Currency = $currency;

        $transfer->DebitedFunds = $debitedFunds;
        $transfer->Fees = $fees;
        $transfer->CreditedFunds = $creditedFunds;

        $myTransfer = $api->Transfers->Create($transfer);

        $dbTransfer = new MangopayOrderTransfert();
        $dbTransfer->setTransactionRef($transactionRef)
            ->setTransactionStatus('')
            ->setEscrowWallet($escrowWallet)
            ->setUserWallet($creditedWalletId)
            ->setTransfertRef($myTransfer->Id)
            ->setTransfertStatus($myTransfer->Status)
            ->save();

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
        /*
        $escrowwallet = new MangopayEscrowwallet();
        $escrowwallet->setUser(0)
            ->setWallet(0)
            ->save();
        */
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

    public function isValidPayment()
    {
        return true;
    }

    public function pay(Order $order)
    {
        if(PaymentMangopay::getDeferredPay() == 1){
            return $this->doDeferredPay($order);
        }
        else{
            return $this->doDirectPay($order);
        }
    }
    public function doDirectPay(Order $order)
    {
        try {

            //Get Amount in cents
            $Amount = $order->getTotalAmount() * 100;

            //No fees
            $Fees = 0;

            //The return url
            $MangopayRouter = $this->getContainer()->get('router.paymentmangopay');
            $returnUrl = URL::getInstance()->absoluteUrl(
                $MangopayRouter->generate(
                    "paymentmangopay.confirmation",
                    array("order_id" => $order->getId()),
                    Router::ABSOLUTE_URL
                )
            );

            //Récupération des données du compte tampon
            $escrowUser = PaymentMangopay::getEscrowUser();
            $escrowWallet = PaymentMangopay::getEscrowWallet();

            //Récupératin du type de carte à utiliser
            //CB_VISA_MASTERCARD MAESTRO DINERS P24 IDEAL BCMC MASTERPASS
            $session = new Session();
            $cardType = $session->get('selectedCardType',null);

            if(!$cardType){
                $cardType = 'CB_VISA_MASTERCARD';
            }

            //Récupération du langage courante
            $session = new Session();
            $defaultLang = $session->getLang()->getCode();

            //Currency
            $currency = $order->getCurrency()->getCode();

            $executionDate = new \DateTime(date('Y/m/d'));

            $api = PaymentMangopay::getMangoPayApi();
            $PayIn = new PayIn();
            $PayIn->CreditedWalletId = $escrowWallet;
            $PayIn->AuthorId = $escrowUser;
            $PayIn->PaymentType = "CARD";
            $PayIn->PaymentDetails = new PayInPaymentDetailsCard();
            $PayIn->PaymentDetails->CardType = $cardType;
            $PayIn->DebitedFunds = new \MangoPay\Money();
            $PayIn->DebitedFunds->Currency = $currency;
            $PayIn->DebitedFunds->Amount = $Amount;
            $PayIn->Fees = new \MangoPay\Money();
            $PayIn->Fees->Currency = $currency;
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
           //Get Amount in cents
            $Amount = $order->getTotalAmount() * 100;

            //No fees
            $Fees = 0;

            //Création d'une carte de paiement
            $api = PaymentMangopay::getMangoPayApi();

            //Récupération des données du compte tampon
            $escrowUser = PaymentMangopay::getEscrowUser();
            $escrowWallet = PaymentMangopay::getEscrowWallet();

            //Currency
            $currency = $order->getCurrency()->getCode();

            $cardRegister = new \MangoPay\CardRegistration();
            $cardRegister->UserId = $escrowUser;
            $cardRegister->Currency = $currency;
            //CB_VISA_MASTERCARD, MAESTRO, DINERS
            $cardRegister->CardType = "CB_VISA_MASTERCARD";
            $result = $api->CardRegistrations->Create($cardRegister);
            var_dump($result);
            $parser = $this->getContainer()->get("thelia.parser");

            $parser->setTemplateDefinition(
                $parser->getTemplateHelper()->getActiveFrontTemplate()
            );

            $renderedTemplate = $parser->render(
                "card-register-mangopay.html",
                array(
                    "order_id" => $order->getId(),
                    "data" => $result->PreregistrationData,
                    "accessKeyRef" => $result->AccessKey,
                    "CardReg" => $result->Id,
                    "user" => $escrowUser,
                    "wallet" => $escrowWallet,
                    "amount" => $Amount
                )
            );

            return Response::create($renderedTemplate);

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
