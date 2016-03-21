<?php
namespace PaymentMangopay\Loop;

use PaymentMangopay\Model\OrderPreauthorisationQuery;
use PaymentMangopay\PaymentMangopay;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\ArraySearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

class PreauthorizationLoop extends BaseLoop implements ArraySearchLoopInterface
{

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('order', 0),
            Argument::createIntTypeArgument('preauthorization', 0)
        );
    }
    public function buildArray()
    {

        $search = OrderPreauthorisationQuery::create();

        if($this->getOrder()!=0){
            $search->filterByOrderId($this->getOrder());
        }
        if($this->getPreauthorization()!=0){
            $search->filterByPreauthorization($this->getPreauthorization());
        }

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
				->set("ORDER_ID", $item->getOrderId())
				->set("PREAUTHORIZATION", $item->getPreauthorization())
				->set("STATUS", $item->getStatus())
				;

			$loopResult->addRow($loopResultRow);
		}
		return $loopResult;
    }

}