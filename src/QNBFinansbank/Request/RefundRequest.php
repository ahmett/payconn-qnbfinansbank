<?php

namespace Payconn\QNBFinansbank\Request;

use Payconn\Common\AbstractRequest;
use Payconn\Common\HttpClient;
use Payconn\Common\ResponseInterface;
use Payconn\QNBFinansbank\Model\Refund;
use Payconn\QNBFinansbank\Response\RefundResponse;
use Payconn\QNBFinansbank\Token;

class RefundRequest extends AbstractRequest
{
    public function send(): ResponseInterface
    {
        /** @var Refund $model */
        $model = $this->getModel();
        /** @var Token $token */
        $token = $this->getToken();

        $body = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8" standalone="yes" ?><PayforRequest></PayforRequest>');
        $body->addChild('MbrId', '5');
        $body->addChild('MerchantID', $token->getMerchantId());
        $body->addChild('UserCode', $token->getUserCode());
        $body->addChild('UserPass', $token->getUserPass());
        $body->addChild('OrgOrderId', $model->getOrderId());
        $body->addChild('SecureType', 'NonSecure');
        $body->addChild('TxnType', 'Refund');
        $body->addChild('PurchAmount', (string) $model->getAmount());
        $body->addChild('Currency', $model->getCurrency());

        /** @var HttpClient $httpClient */
        $httpClient = $this->getHttpClient();
        $response = $httpClient->request('POST', $model->getBaseUrl(), [
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF-8',
            ],
            'body' => $body->asXML(),
        ]);

        return new RefundResponse($model, (array) @simplexml_load_string($response->getBody()->getContents()));
    }
}
