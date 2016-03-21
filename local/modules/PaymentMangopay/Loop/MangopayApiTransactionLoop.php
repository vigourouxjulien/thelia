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

class MangopayApiTransactionLoop extends BaseLoop implements ArraySearchLoopInterface
{

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('wallet', 0)
        );
    }
    public function buildArray()
    {
        $api = PaymentMangopay::getMangoPayApi();

        if(!$api) return array();

        if($this->getWallet()!=0){
            // TODO : gestion de la pagination
            $pagination = new Pagination(1, 100);
            $transactions = $api->Wallets->GetTransactions($this->getWallet(),$pagination);
            return $transactions;
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
        $myCreationDate = new \DateTime();
        foreach ($loopResult->getResultDataCollection() as $entry) {
            $row = new LoopResultRow($entry);
            $myCreationDate->setTimestamp($entry->CreationDate);
            $row
            ->set("AUTHORID", $entry->AuthorId)
            ->set("CREDITEDUSERID", $entry->CreditedUserId)
            ->set("DEBITEDFUNDS_CURRENCY", $entry->DebitedFunds->Currency)
            ->set("DEBITEDFUNDS_AMOUNT", $entry->DebitedFunds->Amount)
            ->set("CREDITEDFUNDS_CURRENCY", $entry->CreditedFunds->Currency)
            ->set("CREDITEDFUNDS_AMOUNT", $entry->CreditedFunds->Amount)
            ->set("FEES_CURRENCY", $entry->Fees->Currency)
            ->set("FEES_AMOUNT", $entry->Fees->Amount)
            ->set("STATUS", $entry->Status)
            ->set("RESULTCODE", $entry->ResultCode)
            ->set("RESULTMESSAGE", $entry->ResultMessage)
            ->set("EXECUTIONDATE", $entry->ExecutionDate)
            ->set("TYPE", $entry->Type)
            ->set("NATURE", $entry->Nature)
            ->set("DEBITEDWALLETID", $entry->DebitedWalletId)
            ->set("CREDITEDWALLETID", $entry->CreditedWalletId)
            ->set("ID", $entry->Id)
            ->set("TAG", $entry->Tag)
            ->set("CREATIONDATE", $myCreationDate->format('Y-m-d'))
            ;

            //$this->addMoreResults($row, $entry);

            $loopResult->addRow($row);
        }

        return $loopResult;
    }

}