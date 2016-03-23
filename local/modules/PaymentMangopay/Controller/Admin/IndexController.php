<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace PaymentMangopay\Controller\Admin;

use PaymentMangopay\Form\ConfigurationForm;
use PaymentMangopay\Model\MangopayConfigurationQuery;
use PaymentMangopay\Model\OrderPreauthorisationQuery;
use PaymentMangopay\PaymentMangopay;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Model\OrderProductQuery;
use Thelia\Model\OrderQuery;
use Thelia\Model\OrderStatus;
use Thelia\Model\OrderStatusQuery;

class IndexController extends BaseAdminController
{
    public function defaultAction(){
        return $this->render('index-mangopay');
    }
    public function usersList(){
        return $this->render('users-index');
    }
    public function payinsList(){
        return $this->render('payins-index');
    }
    public function configurationUpdate(){
        $request = $this->getRequest();
        $configurationForm = new ConfigurationForm($request);
        $form = $this->validateForm($configurationForm);
        $data = $form->getData();

        $myConfiguration = MangopayConfigurationQuery::create()->findPk($data['id']);
        if($myConfiguration){
            $myConfiguration
                ->setFees($data['fees'])
                ->setClientid($data['clientid'])
                ->setClientpassword($data['clientpassword'])
                ->setTemporaryfolder($data['temporaryfolder'])
                ->setDeferredPayment($data['deferred_payment'])
                ->setDays($data['days'])
                ->save()
            ;
        }

        // Set the module router to use module routes
        $this->setCurrentRouter("router.paymentmangopay");
        return $this->generateRedirectFromRoute("paymentmangopay.configuration");
    }
    public function escrowWalletUpdate(){
        $api = PaymentMangopay::getMangoPayApi();

        //Create a natural user
        $legalUser = new UserLegal();

        $legalUser->Tag = 'Escrow Wallet OPEN STUDIO';   //Auto fill tag with firstname lastname
        $legalUser->LegalPersonType = 'OPEN STUDIO';
        $legalUser->Email = 'jvigouroux@openstudio.fr';
        $legalUser->Name = 'OPEN STUDIO';

        $HeadquartersAddress = new Address();
        $HeadquartersAddress->AddressLine1 = '12 Avenue Clément Charbonnier';
        $HeadquartersAddress->City = 'Le Puy-en-Velay';
        $HeadquartersAddress->PostalCode = '43000';
        $HeadquartersAddress->Country = 'FR';

        $legalUser->HeadquartersAddress = $HeadquartersAddress;

        $legalUser->LegalRepresentativeFirstName = 'VIGOUROUX';
        $legalUser->LegalRepresentativeLastName = 'Julien';

        $LegalRepresentativeAddress = new Address();
        $LegalRepresentativeAddress->AddressLine1 = '12 Avenue Clément Charbonnier';
        $LegalRepresentativeAddress->City = 'Le Puy-en-Velay';
        $LegalRepresentativeAddress->PostalCode = '43000';
        $LegalRepresentativeAddress->Country = 'FR';

        $legalUser->LegalRepresentativeAddress = $LegalRepresentativeAddress;

        $legalUser->LegalRepresentativeEmail = 'jvigouroux@openstudio.fr';
        $legalUser->LegalRepresentativeBirthday = 121271;
        $legalUser->LegalRepresentativeNationality = 'FR';
        $legalUser->LegalRepresentativeCountryOfResidence = 'FR';

        $legalUserResult = $api->Users->Create($legalUser);

        //add a wallet for this user
        $wallet = new Wallet();
        $wallet->Owners = array($legalUserResult->Id);
        $wallet->Description = "Escrow wallet OPEN STUDIO";
        //TODO : select currency in form
        $wallet->Currency = "EUR";
        $myWallet = $api->Wallets->Create($wallet);

        //add information in local database
        $myUser = new MangopayWallet();
        $myUser->setUser($legalUserResult->Id)
            ->setWallet($myWallet->Id)
            ->save()
        ;
    }
    public function user(){
        return $this->render('user-mangopay');
    }
    public function preauthorizationList(){
        return $this->render('preauthorization-list');
    }

}