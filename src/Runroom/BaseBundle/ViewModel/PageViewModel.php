<?php

namespace Runroom\BaseBundle\ViewModel;

use Runroom\BaseBundle\Entity\MetaInformation;

class PageViewModel
{
    protected $metas;
    protected $content;
    protected $alternateLinks;

    public function setMetas(MetaInformation $metas)
    {
        $this->metas = $metas;
    }

    public function getMetas()
    {
        return $this->metas;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setAlternateLinks(array $alternateLinks)
    {
        $this->alternateLinks = $alternateLinks;
    }

    public function getAlternateLinks()
    {
        return $this->alternateLinks;
    }
}
