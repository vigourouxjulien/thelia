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

class PaymentMangopayApiLoop extends BaseLoop implements ArraySearchLoopInterface
{

    protected function getArgDefinitions()
    {
        return new ArgumentCollection();
    }
    public function buildArray()
    {
        $api = PaymentMangopay::getMangoPayApi();

        if(!$api) return null;

        $result = array();
        $result[] = array(
            'ClientId' => $api->Config->ClientId,
            'ClientPassword' => $api->Config->ClientPassword,
            'TemporaryFolder' => $api->Config->TemporaryFolder,
        );
        return $result;
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
                ->set("CLIENT_ID", $entry['ClientId'])
                ->set("CLIENT_PASSWORD", $entry['ClientPassword'])
                ->set("TEMPORARY_FOLDER", $entry['TemporaryFolder'])
            ;

            //$this->addMoreResults($row, $entry);

            $loopResult->addRow($row);
        }

        return $loopResult;
    }

}