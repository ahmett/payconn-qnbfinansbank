<?php

namespace Payconn\QNBFinansbank\Request;

use Payconn\Common\AbstractRequest;
use Payconn\Common\HttpClient;
use Payconn\Common\ResponseInterface;
use Payconn\QNBFinansbank\Model\Complete;
use Payconn\QNBFinansbank\Response\CompleteResponse;
use Payconn\QNBFinansbank\Token;

class CompleteRequest extends AbstractRequest
{
    public function send(): ResponseInterface
    {
        /** @var Complete $model */
        $model = $this->getModel();
        /** @var Token $token */
        $token = $this->getToken();

        $body = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8" standalone="yes" ?><PayforRequest></PayforRequest>');
        $body->addChild('RequestGuid', $model->getReturnParams()->get('RequestGuid'));
        $body->addChild('OrderId', $model->getReturnParams()->get('OrderId'));
        $body->addChild('UserCode', $token->getUserCode());
        $body->addChild('UserPass', $token->getUserPass());
        $body->addChild('SecureType', '3DModelPayment');

        /** @var HttpClient $httpClient */
        $httpClient = $this->getHttpClient();
        $response = $httpClient->request('POST', $model->getBaseUrl(), [
            'body' => $body->asXML(),
        ]);

        return new CompleteResponse($model, (array) @simplexml_load_string($response->getBody()->getContents()));
    }
}
