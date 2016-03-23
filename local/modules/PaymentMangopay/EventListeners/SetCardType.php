<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia	                                                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*	    along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/*************************************************************************************/

namespace PaymentMangopay\EventListeners;

use MangoPay\Money;
use MangoPay\Transfer;
use PaymentMangopay\Event\MangopayDispatchPaymentEvent;
use PaymentMangopay\Event\PaymentMangopayEvents;
use PaymentMangopay\PaymentMangopay;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\HttpFoundation\Session\Session;
use Thelia\Core\Template\ParserInterface;
use Thelia\Log\Tlog;
use Thelia\Mailer\MailerFactory;
use Thelia\Model\ConfigQuery;
use Thelia\Model\Lang;
use Thelia\Model\MessageQuery;
use Thelia\Core\HttpFoundation\Request;


use MangoPay\MangoPayApi;
use MangoPay\PayIn;
use MangoPay\PayInExecutionDetailsWeb;
use MangoPay\PayInPaymentDetailsCard;
use MangoPay\Libraries\ResponseException;
use MangoPay\Libraries\Exception;
use MangoPay\Libraries\Logs;

use Symfony\Component\HttpFoundation\RequestStack;


class SetCardType extends BaseAction implements EventSubscriberInterface
{
    /**
     * @var Request
     */
    protected $request;

    //public function __construct(RequestStack $request)
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function getRequest(){
        return $this->request;
    }

    public function set_card_type(OrderEvent $orderEvent){

        $request = $this->getRequest();
        $cardType = $request->get('CardType');
        if($cardType){
            $session = new Session();
            $session->set('selectedCardType',$cardType);
            $session->save();
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            TheliaEvents::ORDER_SET_INVOICE_ADDRESS =>  array("set_card_type", 256),
        );
    }
}
