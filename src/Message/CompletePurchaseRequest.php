<?php

namespace Omnipay\Moneris\Message;

/**
 * Moneris Complete Purchase Request
 */
class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        return $this->getParameter('response');
    }

    public function setResponse($value)
    {
        return $this->setParameter('response', $value);
    }
    public function sendData($data)
    {
        $this->response = new CompletePurchaseResponse($this, $data);
        return $this->response;
    }
}
