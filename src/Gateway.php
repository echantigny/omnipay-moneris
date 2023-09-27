<?php

namespace Omnipay\Moneris;

use Omnipay\Common\AbstractGateway;


class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Moneris';
    }
    public function getDefaultParameters()
    {
        return array(
            'psStoreId' => '',
            'hppKey' => '',
            'checkoutId' => '',
            'testMode' => false
        );
    }
    public function getPsStoreId()
    {
        return $this->getParameter('psStoreId');
    }
    public function setPsStoreId($value)
    {
        return $this->setParameter('psStoreId', $value);
    }
    public function getHppKey()
    {
        return $this->getParameter('hppKey');
    }
    public function setHppKey($value)
    {
        return $this->setParameter('hppKey', $value);
    }
    public function getCheckoutId()
    {
        return $this->getParameter('checkoutId');
    }
    public function setCheckoutId($value)
    {
        return $this->setParameter('checkoutId', $value);
    }
    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }
    public function setTestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Moneris\Message\PurchaseRequest', $parameters);
    }
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Moneris\Message\CompletePurchaseRequest', $parameters);
    }
}
