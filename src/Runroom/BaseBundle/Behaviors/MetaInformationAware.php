<?php

namespace Runroom\BaseBundle\Behaviors;

use Runroom\BaseBundle\Entity\EntityMetaInformation;
use Doctrine\ORM\Mapping as ORM;

trait MetaInformationAware
{
    /**
     * @ORM\OneToOne(targetEntity="Runroom\BaseBundle\Entity\EntityMetaInformation", cascade={"all"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $metaInformation;

    public function setMetaInformation(EntityMetaInformation $metaInformation = null): self
    {
        $this->metaInformation = $metaInformation;

        return $this;
    }

    public function getMetaInformation(): ?EntityMetaInformation
    {
        return $this->metaInformation;
    }
}