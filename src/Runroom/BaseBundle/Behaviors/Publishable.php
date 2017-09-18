<?php

namespace Runroom\BaseBundle\Behaviors;

use Doctrine\ORM\Mapping as ORM;

trait Publishable
{
    /**
     * @ORM\Column(type="bool")
     */
    protected $publish;

    /**
     * Set publish.
     *
     * @param bool $publish
     *
     * @return mixed
     */
    public function setPublish(bool $publish)
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * Get publish.
     *
     * @return bool
     */
    public function getPublish()
    {
        return $this->publish;
    }
}
