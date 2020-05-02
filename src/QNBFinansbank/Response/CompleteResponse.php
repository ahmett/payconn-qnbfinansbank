<?php

namespace Payconn\QNBFinansbank\Response;

use Payconn\Common\AbstractResponse;

class CompleteResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return 'Onaylandı' === $this->getResponseMessage();
    }

    public function getResponseMessage(): string
    {
        return $this->getParameters()->get('ErrMsg');
    }

    public function getResponseCode(): string
    {
        return $this->getParameters()->get('ProcReturnCode');
    }

    public function getResponseBody(): array
    {
        return $this->getParameters()->all();
    }

    public function isRedirection(): bool
    {
        return false;
    }

    public function getRedirectForm(): ?string
    {
        return null;
    }

    public function getOrderId(): string
    {
        return $this->getParameters()->get('TransId');
    }
}
