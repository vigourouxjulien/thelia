<?php
namespace PaymentMangopay\Loop;

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

class MangopayUsersLoop extends BaseLoop implements ArraySearchLoopInterface
{

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('id', 0),
            Argument::createIntTypeArgument('wallet', 0),
            Argument::createIntTypeArgument('user', 0)
        );
    }
    public function buildArray()
    {

        $search = MangopayWalletQuery::create();

        if($this->getId()!=0){
            $search->filterById($this->getId());
        }
        if($this->getWallet()!=0){
            $search->filterByWallet($this->getWallet());
        }
        if($this->getUser()!=0){
            $search->filterByUser($this->getUser());
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
				->set("ID", $item->getId())
				->set("WALLET", $item->getWallet())
				->set("USER", $item->getUser())
				;

			$loopResult->addRow($loopResultRow);
		}
		return $loopResult;
    }

}