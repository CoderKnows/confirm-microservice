<?php

namespace App\Mail;

use App\Code;
use App\Confirm;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;

class CodeEmail extends Mailable
{
    public $code;
    public $object;
    public $subject = 'Подтверждение email';

    /**
     * CodeEmail constructor.
     * @param Confirm $object
     * @param Code $code
     */
    public function __construct($object, $code)
    {
        $this->object = $object;
        $this->code = $code;
    }

    public function build()
    {
        return $this->view('mail.send_code')->with([
            'url' => URL::route('checkCode', ['email' => $this->object->object, 'code' => $this->code->code,]),
        ]);
    }

}
