<?php
namespace PaymentMangopay\Loop;

use PaymentMangopay\Model\MangopayEscrowwalletQuery;
use PaymentMangopay\Model\OrderPreauthorisationQuery;
use PaymentMangopay\PaymentMangopay;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

class EscrowWalletLoop extends BaseLoop implements ArraySearchLoopInterface
{

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
        );
    }
    public function buildArray()
    {

        $search = MangopayEscrowwalletQuery::create();

        $search->find();

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
				->set("USER", $item->getUser())
				->set("WALLET", $item->getWallet())
				;

			$loopResult->addRow($loopResultRow);
		}
		return $loopResult;
    }

}