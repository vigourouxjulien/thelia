<?php
namespace PaymentMangopay\Loop;

use PaymentMangopay\Model\MangopayConfigurationQuery;
use PaymentMangopay\Model\MangopayWalletQuery;
use PaymentMangopay\Model\OrderPreauthorisationQuery;
use PaymentMangopay\PaymentMangopay;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

class MangopayConfigLoop extends BaseLoop implements ArraySearchLoopInterface
{

    protected function getArgDefinitions()
    {
        return new ArgumentCollection();
    }
    public function buildArray()
    {

        $search = MangopayConfigurationQuery::create()->find();

		$items = array();
		foreach ($search as $aResult) {
			$items[] = $aResult;
		}
		return $items;
    }
    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        foreach ($loopResult->getResultDataCollection() as $item) {

			$loopResultRow = new LoopResultRow();

			$loopResultRow
				->set("ID", $item->getId())
				->set("FEES", $item->getFees())
				->set("CLIENTID", $item->getClientid())
				->set("CLIENTPASSWORD", $item->getClientpassword())
				->set("TEMPORARYFOLDER", $item->getTemporaryfolder())
				->set("DEFERREDPAYMENT", $item->getDeferredPayment())
				->set("DAYS", $item->getDays())
				;

			$loopResult->addRow($loopResultRow);
		}
		return $loopResult;
    }

}