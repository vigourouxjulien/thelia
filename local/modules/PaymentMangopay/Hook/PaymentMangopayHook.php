<?php
namespace PaymentMangopay\Hook;

use PaymentMangopay\PaymentMangopay;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class PaymentMangopayHook extends BaseHook
{
    public function onOrderInvoicePaymentExtra(HookRenderEvent $event)
    {
        $html="";
        if(PaymentMangopay::getDeferredPay() != 1) {
            $html = $this->render("card-type-selection.html",array('mode'=>'direct'));
        }
        else{
            $html = $this->render("card-type-selection.html",array('mode'=>'deferred'));
        }
        $event->add($html);
    }

    public function onOrderPlacedAdditionalPaymentInfo(HookRenderEvent $event)
    {
        if(PaymentMangopay::getDeferredPay() == 1) {
            $authnumber = $this->getRequest()->get('authnumber');
            $html = $this->render("hook-orderplaced.html",array("authnumber"=>$authnumber));
            $event->add($html);
        }
    }

    public function onOrderPaymentGatewayBody(HookRenderEvent $event){
        $module = $event->getArgument('module');
        $idMangopay = PaymentMangopay::getModuleId();
        if($module == $idMangopay){
            if(PaymentMangopay::getDeferredPay() == 1) {
                $html = $this->render("hook-defered-payment-gateway.html",array('PAYMENT_MODULE'=>$module));
                $event->add($html);
            }
        }
    }
    public function onOrderPaymentGatewayJavascript(HookRenderEvent $event){
        if(PaymentMangopay::getDeferredPay() == 1) {
            $event->add("");
        }
    }


}