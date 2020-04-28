<?php

namespace Runroom\SeoBundle\Behaviors;

use Doctrine\ORM\Mapping as ORM;
use Runroom\SeoBundle\Entity\EntityMetaInformation;

trait MetaInformationAware
{
    /**
     * @ORM\OneToOne(targetEntity="Runroom\SeoBundle\Entity\EntityMetaInformation", cascade={"all"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $metaInformation;

    public function setMetaInformation(?EntityMetaInformation $metaInformation): self
    {
        $this->metaInformation = $metaInformation;

        return $this;
    }

    public function getMetaInformation(): ?EntityMetaInformation
    {
        return $this->metaInformation;
    }
}
