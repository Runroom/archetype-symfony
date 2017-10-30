<?php

namespace Runroom\BaseBundle\ViewModel;

use Runroom\BaseBundle\Entity\MetaInformation;

class PageViewModel
{
    protected $metas;
    protected $content;
    protected $alternateLinks;

    public function setMetas(MetaInformation $metas): void
    {
        $this->metas = $metas;
    }

    public function getMetas(): ?MetaInformation
    {
        return $this->metas;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setAlternateLinks(array $alternateLinks): void
    {
        $this->alternateLinks = $alternateLinks;
    }

    public function getAlternateLinks(): ?array
    {
        return $this->alternateLinks;
    }
}
