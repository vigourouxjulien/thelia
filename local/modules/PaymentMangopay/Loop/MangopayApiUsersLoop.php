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

class MangopayApiUsersLoop extends BaseLoop implements ArraySearchLoopInterface
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

        if(!$api) return null;

        if($this->getId()!=0){
            $users = $api->Users->Get($this->getId());
        }
        else{
            $pagination = new Pagination(1, 8);
            $users = $api->Users->GetAll($pagination);
        }
        return $users;
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
            /*
            ->set("FIRST_NAME", $entry->FirstName)
            ->set("LAST_NAME", $entry->LastName)
            ->set("ADDRESS", $entry->Address)
            ->set("BIRTHDAY", $entry->Birthday)
            ->set("NATIONALITY", $entry->Nationality)
            ->set("COUNTRY_OF_RESIDENCE", $entry->CountryOfResidence)
            ->set("OCCUPATION", $entry->Occupation)
            ->set("INCOME_RANGE", $entry->IncomeRange)
            ->set("PROOF_OF_IDENTITY", $entry->ProofOfIdentity)
            ->set("PROOF_OF_ADDRESS", $entry->ProofOfAddress)
            */
            if($entry->PersonType === 'LEGAL'){
                $firstName = $entry->LegalRepresentativeFirstName;
                $lastName = $entry->LegalRepresentativeLastName;
                $birthday = $entry-> LegalRepresentativeBirthday;
            }
            else{
                $firstName = $entry->FirstName;
                $lastName = $entry->LastName;
                $birthday = $entry-> Birthday;
            }
            $row
            ->set("ID", $entry->Id)
            ->set("PERSON_TYPE", $entry->PersonType)    //LEGAL || NATURAL
            ->set("EMAIL", $entry->Email)
            ->set("KYC_LEVEL", $entry->KYCLevel)
            ->set("TAG", $entry->Tag)
            ->set("CREATION_DATE", $entry->CreationDate)
            ->set("FIRST_NAME", $firstName)
            ->set("LAST_NAME", $lastName)
            ->set("BIRTHDAY", $birthday)
            ;

            //$this->addMoreResults($row, $entry);

            $loopResult->addRow($row);
        }

        return $loopResult;
    }

}