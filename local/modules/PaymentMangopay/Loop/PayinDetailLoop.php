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

class PayinDetailLoop extends BaseLoop implements ArraySearchLoopInterface
{

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('id', 0)
        );
    }
    public function buildArray()
    {
        if($this->getId()!=0){
            $api = PaymentMangopay::getMangoPayApi();
            $MyPayIn = $api->PayIns->Get($this->getId());
            $result = array();
            $result[] = array(
                'Status' => $MyPayIn->Status,
                'CreditedFundsAmount' => $MyPayIn->CreditedFunds->Amount,
                'CreditedFundsCurrency' => $MyPayIn->CreditedFunds->Currency,
                'DebitedFundsAmount' => $MyPayIn->DebitedFunds->Amount,
                'DebitedFundsCurrency' => $MyPayIn->DebitedFunds->Currency,
                'FeesAmount' => $MyPayIn->Fees->Amount,
                'FeesCurrency' => $MyPayIn->Fees->Currency,
                'Id' => $MyPayIn->Id
            );
            return $result;
        }
        return null;
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

            $row
                ->set("ID", $entry['Id'])
                ->set("STATUS", $entry['Status'])
                ->set("CREDITEDFUNDSAMOUNT", $entry['CreditedFundsAmount'])
                ->set("CREDITEDFUNDSCURRENCY", $entry['CreditedFundsCurrency'])
                ->set("DEBITEDFUNDSAMOUNT", $entry['DebitedFundsAmount'])
                ->set("DEBITEDFUNDSCURRENCY", $entry['DebitedFundsCurrency'])
                ->set("FEESAMOUNT", $entry['FeesAmount'])
                ->set("FEESCURRENCY", $entry['FeesCurrency'])
            ;

            //$this->addMoreResults($row, $entry);

            $loopResult->addRow($row);
        }

        return $loopResult;
    }

}