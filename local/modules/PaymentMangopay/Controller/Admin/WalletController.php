<?php
/**
 * Created by PhpStorm.
 * User: E-FUSION-JULIEN
 * Date: 17/03/2016
 * Time: 13:09
 */

namespace PaymentMangopay\Controller\Admin;

use MangoPay\Address;
use MangoPay\Libraries\Exception;
use MangoPay\Libraries\Logs;
use MangoPay\Libraries\ResponseException;
use MangoPay\UserLegal;
use MangoPay\UserNatural;
use MangoPay\Wallet;
use PaymentMangopay\Form\LegalUserMangopayCreationForm;
use PaymentMangopay\Form\LegalUserMangopayEditionForm;
use PaymentMangopay\Model\MangopayWallet;
use PaymentMangopay\PaymentMangopay;
use Thelia\Controller\Admin\BaseAdminController;

class WalletController extends BaseAdminController
{
    public function userViewWallet($user_id){
        return $this->render('user-wallet',array('user_id'=>$user_id));
    }

    public function refundTransaction($user_id,$transaction_id){

        try {

            $api = PaymentMangopay::getMangoPayApi();

            $transactions = $api->PayIns->Get($transaction_id);

            $DebitedFundsAmount = $transactions->CreditedFunds->Amount;
            $DebitedFundsCurrency = $transactions->CreditedFunds->Currency;

            $CreditedFundsAmount = $transactions->DebitedFunds->Amount;
            $CreditedFundsCurrency = $transactions->DebitedFunds->Currency;

            $FeesAmount = $transactions->Fees->Amount * -1;
            $FeesCurrency = $transactions->Fees->Currency;

            if($transactions->Status === 'SUCCEEDED'){

                $Refund = new \MangoPay\Refund();
                $Refund->AuthorId = $user_id;
                $Refund->CreditedFunds = new \MangoPay\Money();
                $Refund->CreditedFunds->Currency = $CreditedFundsCurrency;
                $Refund->CreditedFunds->Amount = $CreditedFundsAmount;
                $Refund->DebitedFunds = new \MangoPay\Money();
                $Refund->DebitedFunds->Currency = $DebitedFundsCurrency;
                $Refund->DebitedFunds->Amount = $DebitedFundsAmount;
                $Refund->Fees = new \MangoPay\Money();
                $Refund->Fees->Currency = $FeesCurrency;
                $Refund->Fees->Amount = $FeesAmount;

                $result = $api->PayIns->CreateRefund($transaction_id, $Refund);

                if($result->Status === 'SUCCEEDED'){
                    // Set the module router to use module routes
                    $this->setCurrentRouter("router.paymentmangopay");
                    return $this->generateRedirectFromRoute("paymentmangopay.viewwallet",array(),array('user_id'=>$user_id));
                }
            }
            //TODO : gestion des messages d'erreurs
            $this->setCurrentRouter("router.paymentmangopay");
            return $this->generateRedirectFromRoute("paymentmangopay.viewwallet",array(),array('user_id'=>$user_id));

        } catch (ResponseException $e) {

            Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
            Logs::Debug('Message', $e->GetMessage());
            Logs::Debug('Details', $e->GetErrorDetails());

        } catch (Exception $e) {

            Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
        }

    }


}