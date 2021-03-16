<?php

namespace Payconn\QNBFinansbank\Request;

use Payconn\Common\AbstractRequest;
use Payconn\Common\HttpClient;
use Payconn\Common\ResponseInterface;
use Payconn\QNBFinansbank\Model\Purchase;
use Payconn\QNBFinansbank\Response\PurchaseResponse;
use Payconn\QNBFinansbank\Token;

class PurchaseRequest extends AbstractRequest
{
    public function send(): ResponseInterface
    {
        /** @var Purchase $model */
        $model = $this->getModel();
        /** @var Token $token */
        $token = $this->getToken();

        $body = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8" standalone="yes" ?><PayforRequest></PayforRequest>');
        $body->addChild('MbrId', '5');
        $body->addChild('MerchantID', $token->getMerchantId());
        $body->addChild('UserCode', $token->getUserCode());
        $body->addChild('UserPass', $token->getUserPass());
        $body->addChild('OrderId', $model->getOrderId());
        $body->addChild('SecureType', 'NonSecure');
        $body->addChild('TxnType', 'Auth');
        $body->addChild('PurchAmount', (string) $model->getAmount());
        $body->addChild('InstallmentCount', (string) $model->getInstallment());
        $body->addChild('Currency', $model->getCurrency());
        $body->addChild('Pan', $model->getCreditCard()->getNumber());
        $body->addChild('Expiry', $model->getCreditCard()->getExpireMonth().$model->getCreditCard()->getExpireYear());
        $body->addChild('Cvv2', $model->getCreditCard()->getCvv());

        /** @var HttpClient $httpClient */
        $httpClient = $this->getHttpClient();
        $response = $httpClient->request('POST', $model->getBaseUrl(), [
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF-8',
            ],
            'body' => $body->asXML(),
        ]);

        return new PurchaseResponse($model, (array) @simplexml_load_string($response->getBody()->getContents()));
    }
}
