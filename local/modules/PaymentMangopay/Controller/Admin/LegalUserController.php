<?php
/**
 * Created by PhpStorm.
 * User: E-FUSION-JULIEN
 * Date: 17/03/2016
 * Time: 13:09
 */

namespace PaymentMangopay\Controller\Admin;


use MangoPay\Address;
use MangoPay\Libraries\Exception;
use MangoPay\Libraries\Logs;
use MangoPay\Libraries\ResponseException;
use MangoPay\UserLegal;
use MangoPay\UserNatural;
use MangoPay\Wallet;
use PaymentMangopay\Form\LegalUserMangopayCreationForm;
use PaymentMangopay\Form\LegalUserMangopayEditionForm;
use PaymentMangopay\Model\MangopayWallet;
use PaymentMangopay\PaymentMangopay;
use Thelia\Controller\Admin\BaseAdminController;

class LegalUserController extends BaseAdminController
{
    public function legalUserEditModal($user_id){
        return $this->render('modal-legaluser-edit',array('user_id'=>$user_id));
    }
    public function legalUserEdition($user_id){
        try {
            $request = $this->getRequest();
            $userForm = new LegalUserMangopayEditionForm($request);
            $form = $this->validateForm($userForm);
            $data = $form->getData();

            $api = PaymentMangopay::getMangoPayApi();

            //Create a natural user
            $legalUser = $api->Users->GetLegal($user_id);

            $legalUser->Tag = $data['Name'];   //Auto fill tag with firstname lastname
            $legalUser->LegalPersonType = $data['LegalPersonType'];
            $legalUser->Email = $data['Email'];
            $legalUser->Name = $data['Name'];

            $HeadquartersAddress = $legalUser->HeadquartersAddress;
            $HeadquartersAddress->AddressLine1 = $data['HeadquartersAddressAddressLine1'];
            $HeadquartersAddress->AddressLine2 = $data['HeadquartersAddressAddressLine2'];
            $HeadquartersAddress->City = $data['HeadquartersAddressCity'];
            $HeadquartersAddress->Region = $data['HeadquartersAddressRegion'];
            $HeadquartersAddress->PostalCode = $data['HeadquartersAddressPostalCode'];
            $HeadquartersAddress->Country = $data['HeadquartersAddressCountry'];

            $legalUser->HeadquartersAddress = $HeadquartersAddress;

            $legalUser->LegalRepresentativeFirstName = $data['LegalRepresentativeFirstName'];
            $legalUser->LegalRepresentativeLastName = $data['LegalRepresentativeLastName'];

            $LegalRepresentativeAddress = $legalUser->LegalRepresentativeAddress;
            $LegalRepresentativeAddress->AddressLine1 = $data['LegalRepresentativeAddressAddressLine1'];
            $LegalRepresentativeAddress->AddressLine2 = $data['LegalRepresentativeAddressAddressLine2'];
            $LegalRepresentativeAddress->City = $data['LegalRepresentativeAddressCity'];
            $LegalRepresentativeAddress->Region = $data['LegalRepresentativeAddressRegion'];
            $LegalRepresentativeAddress->PostalCode = $data['LegalRepresentativeAddressPostalCode'];
            $LegalRepresentativeAddress->Country = $data['LegalRepresentativeAddressCountry'];

            $legalUser->LegalRepresentativeAddress = $LegalRepresentativeAddress;

            $legalUser->LegalRepresentativeEmail = $data['LegalRepresentativeEmail'];
            $legalUser->LegalRepresentativeBirthday = (int)$data['LegalRepresentativeBirthday'];
            $legalUser->LegalRepresentativeNationality = $data['LegalRepresentativeNationality'];
            $legalUser->LegalRepresentativeCountryOfResidence = $data['LegalRepresentativeCountryOfResidence'];

            $legalUserResult = $api->Users->Update($legalUser);

            // Set the module router to use module routes
            //return $this->generateRedirect($data['success_url']);

            $this->setCurrentRouter("router.paymentmangopay");
            return $this->generateRedirectFromRoute("paymentmangopay.users");


        } catch (ResponseException $e) {

            Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
            Logs::Debug('Message', $e->GetMessage());
            Logs::Debug('Details', $e->GetErrorDetails());

        } catch (Exception $e) {

            Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
        }
    }
    public function legalUserCreate(){

        try {
            $request = $this->getRequest();
            $userForm = new LegalUserMangopayCreationForm($request);
            $form = $this->validateForm($userForm);
            $data = $form->getData();

            $api = PaymentMangopay::getMangoPayApi();

            //Create a natural user
            $legalUser = new UserLegal();

            $legalUser->Tag = $data['Name'];   //Auto fill tag with firstname lastname
            $legalUser->LegalPersonType = $data['LegalPersonType'];
            $legalUser->Email = $data['Email'];
            $legalUser->Name = $data['Name'];

            $HeadquartersAddress = new Address();
            $HeadquartersAddress->AddressLine1 = $data['HeadquartersAddressAddressLine1'];
            $HeadquartersAddress->AddressLine2 = $data['HeadquartersAddressAddressLine2'];
            $HeadquartersAddress->City = $data['HeadquartersAddressCity'];
            $HeadquartersAddress->Region = $data['HeadquartersAddressRegion'];
            $HeadquartersAddress->PostalCode = $data['HeadquartersAddressPostalCode'];
            $HeadquartersAddress->Country = $data['HeadquartersAddressCountry'];

            $legalUser->HeadquartersAddress = $HeadquartersAddress;

            $legalUser->LegalRepresentativeFirstName = $data['LegalRepresentativeFirstName'];
            $legalUser->LegalRepresentativeLastName = $data['LegalRepresentativeLastName'];

            $LegalRepresentativeAddress = new Address();
            $LegalRepresentativeAddress->AddressLine1 = $data['LegalRepresentativeAddressAddressLine1'];
            $LegalRepresentativeAddress->AddressLine2 = $data['LegalRepresentativeAddressAddressLine2'];
            $LegalRepresentativeAddress->City = $data['LegalRepresentativeAddressCity'];
            $LegalRepresentativeAddress->Region = $data['LegalRepresentativeAddressRegion'];
            $LegalRepresentativeAddress->PostalCode = $data['LegalRepresentativeAddressPostalCode'];
            $LegalRepresentativeAddress->Country = $data['LegalRepresentativeAddressCountry'];

            $legalUser->LegalRepresentativeAddress = $LegalRepresentativeAddress;

            $legalUser->LegalRepresentativeEmail = $data['LegalRepresentativeEmail'];
            $legalUser->LegalRepresentativeBirthday = (int)$data['LegalRepresentativeBirthday'];
            $legalUser->LegalRepresentativeNationality = $data['LegalRepresentativeNationality'];
            $legalUser->LegalRepresentativeCountryOfResidence = $data['LegalRepresentativeCountryOfResidence'];

            $legalUserResult = $api->Users->Create($legalUser);

            //add a wallet for this user
            $wallet = new Wallet();
            $wallet->Owners = array($legalUserResult->Id);
            $wallet->Description = "wallet for ".$legalUserResult->Id;
            //TODO : select currency in form
            $wallet->Currency = "EUR";
            $myWallet = $api->Wallets->Create($wallet);

            //add information in local database
            $myUser = new MangopayWallet();
            $myUser->setUser($legalUserResult->Id)
                ->setWallet($myWallet->Id)
                ->setIsDefault($data['isdefault'])
                ->save()
            ;

            // Set the module router to use module routes
            //return $this->generateRedirect($data['success_url']);

            $this->setCurrentRouter("router.paymentmangopay");
            return $this->generateRedirectFromRoute("paymentmangopay.users");


        } catch (ResponseException $e) {

            Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
            Logs::Debug('Message', $e->GetMessage());
            Logs::Debug('Details', $e->GetErrorDetails());

        } catch (Exception $e) {

            Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
        }
    }
}