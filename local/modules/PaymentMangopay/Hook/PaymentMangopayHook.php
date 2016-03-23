<?php
namespace PaymentMangopay\Hook;

use PaymentMangopay\PaymentMangopay;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class PaymentMangopayHook extends BaseHook
{
    public function onOrderInvoicePaymentExtra(HookRenderEvent $event)
    {
        if(PaymentMangopay::getDeferredPay() != 1) {
            $html = $this->render("card-type-selection.html");
            $event->add($html);
        }
    }

}