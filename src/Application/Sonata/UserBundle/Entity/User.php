<?php

namespace Application\Sonata\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;

class User extends BaseUser
{
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
