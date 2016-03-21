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

class MangopayApiNaturalUsersLoop extends BaseLoop implements ArraySearchLoopInterface
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
            $users = $api->Users->GetNatural($this->getId());
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
            ->set("PERSON_TYPE", $entry->PersonType)    //LEGAL || NATURAL
            ->set("EMAIL", $entry->Email)
            ->set("KYC_LEVEL", $entry->KYCLevel)
            ->set("TAG", $entry->Tag)
            ->set("CREATION_DATE", $entry->CreationDate)
            ->set("FIRST_NAME", $entry->FirstName)
            ->set("LAST_NAME", $entry->LastName)
            ->set("BIRTHDAY", $entry->Birthday)
            ->set("NATIONALITY", $entry->Nationality)
            ->set("COUNTRYOFRESIDENCE", $entry->CountryOfResidence)
            ->set("OCCUPATION", $entry->Occupation)
            ->set("INCOMERANGE", $entry->IncomeRange)
            ->set("PROOFOFIDENTITY", $entry->ProofOfIdentity)
            ->set("PROOFOFADDRESS", $entry->ProofOfAddress)
            ->set("ADDRESSLINE1", $entry->Address->AddressLine1)
            ->set("ADDRESSLINE2", $entry->Address->AddressLine2)
            ->set("CITY", $entry->Address->City)
            ->set("REGION", $entry->Address->Region)
            ->set("POSTALCODE", $entry->Address->PostalCode)
            ->set("COUNTRY", $entry->Address->Country)
            ;

            //$this->addMoreResults($row, $entry);

            $loopResult->addRow($row);
        }

        return $loopResult;
    }

}