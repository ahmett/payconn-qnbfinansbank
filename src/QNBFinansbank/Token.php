<?php

namespace Payconn\QNBFinansbank;

use Payconn\Common\TokenInterface;

class Token implements TokenInterface
{
    private $merchantId;

    private $merchantPass;

    private $userCode;

    private $userPass;

    public function __construct(string $merchantId, string $merchantPass, string $userCode, string $userPass)
    {
        $this->merchantId = $merchantId;
        $this->merchantPass = $merchantPass;
        $this->userCode = $userCode;
        $this->userPass = $userPass;
    }

    public function getMerchantId(): string
    {
        return $this->merchantId;
    }

    public function getMerchantPass(): string
    {
        return $this->merchantPass;
    }

    public function getUserCode(): string
    {
        return $this->userCode;
    }

    public function getUserPass(): string
    {
        return $this->userPass;
    }
}
