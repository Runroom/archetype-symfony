<?php

namespace Tests\Runroom\TranslationsBundle\MotherObjects;

use Runroom\TranslationsBundle\Entity\Message;

class MessageMotherObject
{
    const ID = 1;
    const KEY = 'my.key';
    const VALUE = 'My value';

    public static function create(): Message
    {
        $message = new Message();

        $message->setId(self::ID);
        $message->setKey(self::KEY);
        $message->translate()->setValue(self::VALUE);

        return $message;
    }
}
