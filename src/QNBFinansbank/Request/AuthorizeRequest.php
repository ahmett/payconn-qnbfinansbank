<?php

namespace Payconn\QNBFinansbank\Request;

use Payconn\Common\AbstractRequest;
use Payconn\Common\HttpClient;
use Payconn\Common\ResponseInterface;
use Payconn\QNBFinansbank\Model\Authorize;
use Payconn\QNBFinansbank\Response\AuthorizeResponse;
use Payconn\QNBFinansbank\Token;

class AuthorizeRequest extends AbstractRequest
{
    public function send(): ResponseInterface
    {
        /** @var Authorize $model */
        $model = $this->getModel();
        /** @var Token $token */
        $token = $this->getToken();

        $mbrId = '5';
        $txnType = 'Auth';
        $rnd = microtime();
        $hash = base64_encode(pack('H*', sha1($mbrId.$model->getOrderId().$model->getAmount().$model->getSuccessfulUrl().$model->getFailureUrl().$txnType.$model->getInstallment().$rnd.$token->getMerchantPass())));

        /** @var HttpClient $httpClient */
        $httpClient = $this->getHttpClient();
        $response = $httpClient->request('POST', $model->getBaseUrl(), [
            'form_params' => [
                'MbrId' => $mbrId,
                'MerchantID' => $token->getMerchantId(),
                'UserCode' => $token->getUserCode(),
                'SecureType' => '3DModel',
                'TxnType' => $txnType,
                'InstallmentCount' => $model->getInstallment(),
                'Currency' => $model->getCurrency(),
                'Pan' => $model->getCreditCard()->getNumber(),
                'Expiry' => $model->getCreditCard()->getExpireMonth().$model->getCreditCard()->getExpireYear(),
                'Cvv2' => $model->getCreditCard()->getCvv(),
                'OkUrl' => $model->getSuccessfulUrl(),
                'FailUrl' => $model->getFailureUrl(),
                'OrderId' => $model->getOrderId(),
                'PurchAmount' => $model->getAmount(),
                'Rnd' => $rnd,
                'Hash' => $hash,
            ],
        ]);

        return new AuthorizeResponse($model, ['content' => $response->getBody()->getContents()]);
    }
}
