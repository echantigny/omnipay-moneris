<?php

namespace Omnipay\Moneris\Message;

use craft\commerce\Plugin;
use echantigny\commerce\moneris\gateways\MonerisHostedCheckout;


/**
 * Moneris Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{

    public function getData()
    {
        $data = [];

        $data['txn_total'] = $this->getAmount();

        $data['contact_details']['first_name'] = $this->getCard()->getFirstname();
        $data['contact_details']['last_name'] = $this->getCard()->getLastname();
        $data['contact_details']['phone'] = $this->getCard()->getPhone();
        $data['contact_details']['email'] = $this->getCard()->getEmail();

        $token = $this->getTicket($data);

        $return = [];
        $return['payment_token'] = $token;

        return $return;
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    private function getTicket($data)
    {

        $data["store_id"] = $this->getPsStoreId();
        $data["api_token"] = $this->getHppKey();
        $data["checkout_id"] = $this->getCheckoutId();
        $data["environment"] = ($this->getTestMode()) ? "qa":"prod";
        $data["action"] = "preload";
        do {

            $data['order_no'] = $this->getTransactionId()."_".time();

            $payload = json_encode($data);
            // Prepare new cURL resource
            $ch = curl_init('https://gatewayt.moneris.com/chkt/request/request.php');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

            // Set HTTP Header for POST request
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: '.strlen($payload)
                ]
            );

            // Submit the POST request
            $result = curl_exec($ch);

            // Close cURL session handle
            curl_close($ch);

            $result_data = json_decode($result, true);

            if (isset($result_data['response']['error']) && (!(bool)$result_data['response']['success'])) {

            }

        } while (isset($result_data['response']['error']['order_no']));
        return $result_data['response']['ticket'];
    }
}