<?php

namespace Payconn\QNBFinansbank\Model;

use Payconn\Common\AbstractModel;
use Payconn\Common\Model\CompleteInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

class Complete extends AbstractModel implements CompleteInterface
{
    /**
     * @var ParameterBag
     */
    protected $returnParams;

    public function __construct()
    {
        $this->returnParams = new ParameterBag();
    }

    public function setReturnParams(array $returnParams): void
    {
        $this->returnParams = new ParameterBag($returnParams);
    }

    public function getReturnParams(): ParameterBag
    {
        return $this->returnParams;
    }
}
