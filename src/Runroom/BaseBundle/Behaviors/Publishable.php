<?php

namespace Runroom\BaseBundle\Behaviors;

use Doctrine\ORM\Mapping as ORM;

trait Publishable
{
    /**
     * @ORM\Column(type="boolean")
     */
    protected $publish;

    /**
     * @param bool $publish
     *
     * @return mixed
     */
    public function setPublish(?bool $publish)
    {
        $this->publish = $publish;

        return $this;
    }

    public function getPublish(): ?bool
    {
        return $this->publish;
    }
}
