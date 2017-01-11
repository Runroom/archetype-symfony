<?php

namespace Tests\Runroom\TranslationsBundle\MotherObjects;

use Runroom\TranslationsBundle\Entity\Message;

class MessageMotherObject
{
    const ID = 1;
    const KEY = 'my.key';
    const VALUE = 'My value';

    public static function create()
    {
        $message = new Message();

        $message->setId(self::ID);
        $message->setKey(self::KEY);
        $message->setValue(self::VALUE);

        return $message;
    }
}
