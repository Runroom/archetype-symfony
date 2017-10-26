<?php

namespace Runroom\BaseBundle\Behaviors;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait Sortable
{
    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer")
     */
    protected $position;

    /**
     * @param int $position
     *
     * @return mixed
     */
    public function setPosition(?int $position)
    {
        $this->position = $position;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }
}
