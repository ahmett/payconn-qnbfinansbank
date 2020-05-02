<?php

namespace Payconn\QNBFinansbank\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Payconn\Common\HttpClient;
use PHPUnit\Framework\TestCase;

class AuthorizeTest extends TestCase
{
    public function testSuccessful(): void
    {
        $responseBody = 'REDIRECT_FORM';
        $response = new Response(200, [], $responseBody);
        $mock = new MockHandler([
           $response,
        ]);
        $handler = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handler]);

        $token = new \Payconn\QNBFinansbank\Token('085300000009704', '12345678', 'QNB_API_KULLANICI_3DPAY', 'UcBN0');
        $creditCard = new \Payconn\Common\CreditCard('4155650100416111', '25', '01', '123');
        $authorize = new \Payconn\QNBFinansbank\Model\Authorize();

        $authorize->setTestMode(true);
        $authorize->setCurrency(\Payconn\QNBFinansbank\Currency::TRY);
        $authorize->setAmount(1);
        $authorize->setInstallment(0);
        $authorize->setCreditCard($creditCard);
        $authorize->setSuccessfulUrl('http://127.0.0.1:8000/successful');
        $authorize->setFailureUrl('http://127.0.0.1:8000/failure');
        $authorize->generateOrderId();

        $response = (new \Payconn\QNBFinansbank($token, $client))->authorize($authorize);

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($responseBody, $response->getRedirectForm());
    }
}
