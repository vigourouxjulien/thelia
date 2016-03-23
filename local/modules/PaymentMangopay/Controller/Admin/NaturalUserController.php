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
use MangoPay\UserNatural;
use MangoPay\Wallet;
use PaymentMangopay\Form\NaturalUserMangopayCreationForm;
use PaymentMangopay\Form\NaturalUserMangopayEditionForm;
use PaymentMangopay\Model\MangopayWallet;
use PaymentMangopay\PaymentMangopay;
use Thelia\Controller\Admin\BaseAdminController;

class NaturalUserController extends BaseAdminController
{
    public function naturalUserEditModal($user_id){
        return $this->render('modal-naturaluser-edit',array('user_id'=>$user_id));
    }
    public function naturalUserEdition($user_id){
        try {
            $request = $this->getRequest();
            $userForm = new NaturalUserMangopayEditionForm($request);
            $form = $this->validateForm($userForm);
            $data = $form->getData();

            $api = PaymentMangopay::getMangoPayApi();

            //Create a natural user
            $naturalUser = $api->Users->GetNatural($user_id);

            $naturalUser->Tag = $data['tag'];
            $naturalUser->Email = $data['email'];
            $naturalUser->FirstName = $data['firstname'];
            $naturalUser->LastName = $data['lastname'];
            $naturalUser->Birthday = (int)$data['birthday'];    //cas birthday in int //121271
            $naturalUser->Nationality = $data['nationality'];
            $naturalUser->CountryOfResidence = $data['countryofresidence'];

            $address = $naturalUser->Address;
            $address->AddressLine1 = $data['addressline1'];
            $address->AddressLine2 = $data['addressline2'];
            $address->City = $data['city'];
            $address->Region = $data['region'];
            $address->PostalCode = $data['postalcode'];
            $address->Country = $data['country'];

            $naturalUser->Address = $address;

            $naturalUserResult = $api->Users->Update($naturalUser);

            // Set the module router to use module routes
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
    public function naturalUserCreate(){

        try {
            $request = $this->getRequest();
            $userForm = new NaturalUserMangopayCreationForm($request);
            $form = $this->validateForm($userForm);
            $data = $form->getData();

            $api = PaymentMangopay::getMangoPayApi();

            //Create a natural user
            $naturalUser = new UserNatural();

            $naturalUser->Tag = $data['firstname'].' '.$data['lastname'];   //Auto fill tag with firstname lastname
            $naturalUser->Email = $data['email'];
            $naturalUser->FirstName = $data['firstname'];
            $naturalUser->LastName = $data['lastname'];
            $naturalUser->Birthday = (int)$data['birthday'];    //cas birthday in int //121271
            $naturalUser->Nationality = $data['nationality'];
            $naturalUser->CountryOfResidence = $data['countryofresidence'];

            $address = new Address();
            $address->AddressLine1 = $data['addressline1'];
            $address->AddressLine2 = $data['addressline2'];
            $address->City = $data['city'];
            $address->Region = $data['region'];
            $address->PostalCode = $data['postalcode'];
            $address->Country = $data['country'];

            $naturalUser->Address = $address;

            $naturalUserResult = $api->Users->Create($naturalUser);

            //add a wallet for this user
            $wallet = new Wallet();
            $wallet->Owners = array($naturalUserResult->Id);
            $wallet->Description = "wallet for ".$naturalUserResult->Id;
            //TODO : select currency in form
            $wallet->Currency = "EUR";
            $myWallet = $api->Wallets->Create($wallet);

            //add information in local database
            $myUser = new MangopayWallet();
            $myUser->setUser($naturalUserResult->Id)
                ->setWallet($myWallet->Id)
                ->save()
            ;

            // Set the module router to use module routes
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