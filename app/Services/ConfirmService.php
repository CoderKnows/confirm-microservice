<?php

namespace App\Services;

use App\Code;
use App\Confirm;
use App\ConfirmType;
use Illuminate\Support\Arr;

class ConfirmService
{
    protected function generateCode()
    {
        return mt_rand(1000, 9999);
    }

    /**
     * @param string $object
     * @param integer $type
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getObject($object, $type)
    {
        $confirm = Confirm::query()
            ->where('object', '=',$object)
            ->where('type', '=', $type)
            ->firstOrNew();

        if (!$confirm->id) {
            $confirm->object = $object;
            $confirm->type = $type;
            $confirm->save();
        }

        return $confirm;
    }

    /**
     * @param Confirm $object
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    protected function getCode($object)
    {
        /** @var Code $code */
        $code = $object
            ->codes()
            ->where('is_active', '=', true)
            ->whereDate('valid_to', '>', new \DateTime())
            ->firstOrNew([]);

        if (!$code->id) {
            $code->code = $this->generateCode();
            $code->valid_to = (new \DateTime())->add(new \DateInterval('PT300S'));
            $code->save();
        }

        return $code;
    }

    public function getVerifyingService($queryData)
    {
        if (Arr::exists($queryData, 'email')) {
            /** @var EmailService $service */
            $service = app()->get(EmailService::class);
            $object = $this->getObject(Arr::get($queryData, 'email'), ConfirmType::EMAIL);
            $code = $this->getCode($object);
            $service->setObject($object);
            $service->setCode($code);
            return $service;
        }

        return null;
    }

    public function forConfirming($queryData)
    {
        return Arr::has($queryData, 'code');
    }

    public function confirm($queryData)
    {

    }
}
