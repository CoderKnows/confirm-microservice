<?php

namespace App;

class ConfirmType
{
    const EMAIL = 1;
    const PHONE = 2;
    const TELEGRAM = 3;

    static public function listTypesAll()
    {
        return [
            self::EMAIL => 'email',
            self::PHONE => 'phone',
            self::TELEGRAM => 'telegram',
        ];
    }

    static public function listTypesWithout($types = [])
    {
        return array_diff(self::listTypesAll(), $types);
    }
}
