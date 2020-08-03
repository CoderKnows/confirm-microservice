<?php

namespace App\Services;

use App\Code;
use App\Confirm;
use App\Mail\CodeEmail;
use Illuminate\Support\Facades\Mail;

class EmailService extends AbstractTypeService
{
    public function send()
    {
        Mail::to($this->object->object)->send(new CodeEmail($this->object, $this->code));
    }
}
