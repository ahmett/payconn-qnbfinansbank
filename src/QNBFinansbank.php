<?php

namespace Payconn;

use Payconn\Common\AbstractGateway;
use Payconn\Common\BaseUrl;
use Payconn\Common\Model\AuthorizeInterface;
use Payconn\Common\Model\CancelInterface;
use Payconn\Common\Model\CompleteInterface;
use Payconn\Common\Model\PurchaseInterface;
use Payconn\Common\Model\RefundInterface;
use Payconn\Common\ResponseInterface;
use Payconn\QNBFinansbank\Request\AuthorizeRequest;
use Payconn\QNBFinansbank\Request\CancelRequest;
use Payconn\QNBFinansbank\Request\CompleteRequest;
use Payconn\QNBFinansbank\Request\PurchaseRequest;
use Payconn\QNBFinansbank\Request\RefundRequest;

class QNBFinansbank extends AbstractGateway
{
    public function initialize(): void
    {
        $this->setBaseUrl((new BaseUrl())
            ->setProdUrls('https://vpos.qnbfinansbank.com/Gateway/XMLGate.aspx', 'https://vpos.qnbfinansbank.com/Gateway/Default.aspx')
            ->setTestUrls('https://vpostest.qnbfinansbank.com/Gateway/XMLGate.aspx', 'https://vpostest.qnbfinansbank.com/Gateway/Default.aspx'));
    }

    public function authorize(AuthorizeInterface $authorize): ResponseInterface
    {
        return $this->createRequest(AuthorizeRequest::class, $authorize);
    }

    public function complete(CompleteInterface $complete): ResponseInterface
    {
        return $this->createRequest(CompleteRequest::class, $complete);
    }

    public function purchase(PurchaseInterface $purchase): ResponseInterface
    {
        return $this->createRequest(PurchaseRequest::class, $purchase);
    }

    public function refund(RefundInterface $refund): ResponseInterface
    {
        return $this->createRequest(RefundRequest::class, $refund);
    }

    public function cancel(CancelInterface $cancel): ResponseInterface
    {
        return $this->createRequest(CancelRequest::class, $cancel);
    }
}
