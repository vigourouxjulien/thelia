<?php

/**
 * Created by PhpStorm.
 * User: E-FUSION-JULIEN
 * Date: 11/03/2016
 * Time: 10:55
 */
namespace PaymentMangopay\Loop;

use PaymentMangopay\PaymentMangopay;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

use MangoPay\Pagination;

class MangopayApiRefundLoop extends BaseLoop implements ArraySearchLoopInterface
{

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('transaction', 0)
        );
    }
    public function buildArray()
    {
        $api = PaymentMangopay::getMangoPayApi();

        if(!$api) return array();

        if($this->getTransaction()!=0){
            $refund = $api->Refunds->Get($this->getTransaction());
            return array($refund);
        }

        return array();
    }
    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        foreach ($loopResult->getResultDataCollection() as $entry) {
            $row = new LoopResultRow($entry);
            /* exemple :
            object(MangoPay\Refund)[3778]
              public 'InitialTransactionId' => string '11468065' (length=8)
              public 'InitialTransactionType' => string 'PAYIN' (length=5)
              public 'DebitedWalletId' => string '11463820' (length=8)
              public 'CreditedWalletId' => null
              public 'RefundReason' =>
                object(MangoPay\RefundReasonDetails)[3804]
                  public 'RefundReasonMessage' => null
                  public 'RefundReasonType' => string 'INITIALIZED_BY_CLIENT' (length=21)
              public 'AuthorId' => string '11463819' (length=8)
              public 'CreditedUserId' => null
              public 'DebitedFunds' =>
                object(MangoPay\Money)[3799]
                  public 'Currency' => string 'EUR' (length=3)
                  public 'Amount' => int 468
              public 'CreditedFunds' =>
                object(MangoPay\Money)[3800]
                  public 'Currency' => string 'EUR' (length=3)
                  public 'Amount' => int 520
              public 'Fees' =>
                object(MangoPay\Money)[3806]
                  public 'Currency' => string 'EUR' (length=3)
                  public 'Amount' => int -52
              public 'Status' => string 'SUCCEEDED' (length=9)
              public 'ResultCode' => string '000000' (length=6)
              public 'ResultMessage' => string 'Success' (length=7)
              public 'ExecutionDate' => int 1458315647
              public 'Type' => string 'PAYOUT' (length=6)
              public 'Nature' => string 'REFUND' (length=6)
              public 'Id' => string '11468567' (length=8)
              public 'Tag' => null
              public 'CreationDate' => int 1458315646
            */

            $row
            ->set("INITIALTRANSACTIONID", $entry->InitialTransactionId)
            ;

            //$this->addMoreResults($row, $entry);

            $loopResult->addRow($row);
        }

        return $loopResult;
    }

}