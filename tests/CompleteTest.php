<?php

namespace Payconn\QNBFinansbank\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Payconn\Common\HttpClient;
use PHPUnit\Framework\TestCase;

class CompleteTest extends TestCase
{
    /**
     * @covers \Payconn\QNBFinansbank\Model\Complete
     */
    public function testSuccessful(): void
    {
        $response = new Response(200, [], '<?xml version="1.0" encoding="utf-8"?>
            <PayforResponse>
                <ErrMsg>Onaylandı</ErrMsg>
            </PayforResponse>');
        $mock = new MockHandler([
            $response,
        ]);
        $handler = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handler]);

        $token = new \Payconn\QNBFinansbank\Token('085300000009704', '12345678', 'QNB_API_KULLANICI_3DPAY', 'UcBN0');
        $complete = new \Payconn\QNBFinansbank\Model\Complete();

        $complete->setTestMode(true);
        $complete->setReturnParams([
            'RequestGuid' => 'ExampleRequestGuid',
            'OrderId' => 'ExampleOrderId',
        ]);

        $response = (new \Payconn\QNBFinansbank($token, $client))->complete($complete);

        $this->assertTrue($response->isSuccessful());
    }
}
