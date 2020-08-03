<?php

namespace App\Services;

abstract class AbstractTypeService
{
    protected $object;
    protected $code;

    public function setObject($object)
    {
        $this->object = $object;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    abstract public function send($target, $code);

}
