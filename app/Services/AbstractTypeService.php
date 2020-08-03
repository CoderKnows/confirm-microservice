<?php

namespace App\Services;

use App\Code;
use App\Confirm;

abstract class AbstractTypeService
{
    /** @var Confirm */
    protected $object;

    /** @var Code */
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

    public function updateSendStats()
    {
        $this->object->send_count++;
        $this->object->save();
    }

    public function updateTryStats()
    {

    }

    abstract public function send();

}
