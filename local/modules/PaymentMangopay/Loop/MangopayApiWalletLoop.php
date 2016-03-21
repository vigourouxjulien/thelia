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

class MangopayApiWalletLoop extends BaseLoop implements ArraySearchLoopInterface
{

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('id', 0)
        );
    }
    public function buildArray()
    {
        $api = PaymentMangopay::getMangoPayApi();

        if(!$api) return array();

        if($this->getId()!=0){
            $wallet = $api->Wallets->Get($this->getId());
            return array($wallet);
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
            /* exemple
            object(MangoPay\Wallet)[3721]
              public 'Owners' =>
                array (size=1)
                  0 => string '11463819' (length=8)
              public 'Description' => string 'wallet for 11463819' (length=19)
              public 'Balance' =>
                object(MangoPay\Money)[3734]
                  public 'Currency' => string 'EUR' (length=3)
                  public 'Amount' => int 0
              public 'Currency' => string 'EUR' (length=3)
              public 'Id' => string '11463820' (length=8)
              public 'Tag' => null
              public 'CreationDate' => int 1458307727
            */

            $row
            ->set("DESCRIPTION", $entry->Description)
            ->set("CURRENCY", $entry->Balance->Currency)
            ->set("AMOUNT", $entry->Balance->Amount)
            ->set("ID", $entry->Id->Amount)
            ->set("TAG", $entry->Tag->Currency)
            ->set("CREATIONDATE", $entry->CreationDate->Amount)
            ;

            //$this->addMoreResults($row, $entry);

            $loopResult->addRow($row);
        }

        return $loopResult;
    }

}