<?php

namespace Payconn\QNBFinansbank\Model;

use Payconn\Common\AbstractModel;
use Payconn\Common\Model\RefundInterface;
use Payconn\Common\Traits\Amount;
use Payconn\Common\Traits\Currency;
use Payconn\Common\Traits\OrderId;

class Refund extends AbstractModel implements RefundInterface
{
    use OrderId;
    use Amount;
    use Currency;
}
