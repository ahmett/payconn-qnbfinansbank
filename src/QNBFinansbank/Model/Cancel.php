<?php

namespace Payconn\QNBFinansbank\Model;

use Payconn\Common\AbstractModel;
use Payconn\Common\Model\CancelInterface;
use Payconn\Common\Traits\Currency;
use Payconn\Common\Traits\OrderId;

class Cancel extends AbstractModel implements CancelInterface
{
    use OrderId;
    use Currency;
}
