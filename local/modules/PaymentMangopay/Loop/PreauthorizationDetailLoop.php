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

class PreauthorizationDetailLoop extends BaseLoop implements ArraySearchLoopInterface
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

            if(!$api) return null;

            $MyPreauthorization = $api->CardPreAuthorizations->Get($this->getId());
            $result = array();
            $result[] = array(
                'Amount' => $MyPreauthorization->DebitedFunds->Amount,
                'Currency' => $MyPreauthorization->DebitedFunds->Currency,
                'CardId' => $MyPreauthorization->CardId,
                'Id' => $MyPreauthorization->Id,
                'Status' => $MyPreauthorization->Status,
                'PaymentStatus' => $MyPreauthorization->PaymentStatus,
                'payinId' => $MyPreauthorization->PayInId
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
                ->set("AMOUNT", $entry['Amount'])
                ->set("CURRENCY", $entry['Currency'])
                ->set("CARDID", $entry['CardId'])
                ->set("ID", $entry['Id'])
                ->set("STATUS", $entry['Status'])
                ->set("PAYMENTSTATUS", $entry['PaymentStatus'])
                ->set("PAYINID", $entry['payinId'])
            ;

            //$this->addMoreResults($row, $entry);

            $loopResult->addRow($row);
        }

        return $loopResult;
    }

}