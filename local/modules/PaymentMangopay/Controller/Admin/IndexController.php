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
    public function user(){
        return $this->render('user-mangopay');
    }
    public function preauthorizationList(){
        return $this->render('preauthorization-list');
    }

}