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

class MangopayApiLegalUsersLoop extends BaseLoop implements ArraySearchLoopInterface
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
            if(!$api) return array();
            $users = $api->Users->GetLegal($this->getId());
            return array($users);
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

            $row
            ->set("ID", $entry->Id)
            ->set("TAG", $entry->Tag)
            ->set("EMAIL", $entry->Email)
            ->set("NAME", $entry->Name)
            ->set("LEGALPERSONTYPE", $entry->LegalPersonType)
            ->set("AQADDRESSLINE1", $entry->HeadquartersAddress->AddressLine1)
            ->set("AQADDRESSLINE2", $entry->HeadquartersAddress->AddressLine2)
            ->set("AQCITY", $entry->HeadquartersAddress->City)
            ->set("AQREGION", $entry->HeadquartersAddress->Region)
            ->set("AQPOSTALCODE", $entry->HeadquartersAddress->PostalCode)
            ->set("AQCOUNTRY", $entry->HeadquartersAddress->Country)
            ->set("LEGALREPRESENTATIVEFIRSTNAME", $entry->LegalRepresentativeFirstName)
            ->set("LEGALREPRESENTATIVELASTNAME", $entry->LegalRepresentativeLastName)
            ->set("LRADDRESSLINE1", $entry->LegalRepresentativeAddress->AddressLine1)
            ->set("LRADDRESSLINE2", $entry->LegalRepresentativeAddress->AddressLine2)
            ->set("LRCITY", $entry->LegalRepresentativeAddress->City)
            ->set("LRREGION", $entry->LegalRepresentativeAddress->Region)
            ->set("LRPOSTALCODE", $entry->LegalRepresentativeAddress->PostalCode)
            ->set("LRCOUNTRY", $entry->LegalRepresentativeAddress->Country)
            ->set("LEGALREPRESENTATIVEEMAIL", $entry->LegalRepresentativeEmail)
            ->set("LEGALREPRESENTATIVEBIRTHDAY", $entry->LegalRepresentativeBirthday)
            ->set("LEGALREPRESENTATIVENATIONALITY", $entry->LegalRepresentativeNationality)
            ->set("LEGALREPRESENTATIVECOUNTRYOFRESIDENCE", $entry->LegalRepresentativeCountryOfResidence)
            ;

            //$this->addMoreResults($row, $entry);

            $loopResult->addRow($row);
        }

        return $loopResult;
    }

}