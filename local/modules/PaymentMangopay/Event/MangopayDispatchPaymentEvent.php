<?php

namespace PaymentMangopay\Event;

use Symfony\Component\HttpFoundation\Response;
use Thelia\Core\Event\ActionEvent;
use Thelia\Model\Order;

class MangopayDispatchPaymentEvent extends ActionEvent
{
    private $tabDispatch;
    private $order;

    public function __construct(Order $order)
    {
        $this->setOrder($order);
    }

    /**
     * @param Order $order
     * @return $this
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;

        return $this;
    }
    /**
     * @param array $tabDispatch
     * @return $this
     */
    public function setTabDispatch($tabDispatch){
        $this->tabDispatch = $tabDispatch;
    }
    /**
     * @return array tabDispatch
     */
    public function getTabDispatch(){
        return $this->tabDispatch;
    }
    /**
     * @return Order the order
     */
    public function getOrder()
    {
        return $this->order;
    }
}