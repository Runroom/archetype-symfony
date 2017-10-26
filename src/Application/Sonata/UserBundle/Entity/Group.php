<?php

namespace Application\Sonata\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseGroup as BaseGroup;

class Group extends BaseGroup
{
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
