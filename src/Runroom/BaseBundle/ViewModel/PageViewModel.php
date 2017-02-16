<?php

namespace Runroom\BaseBundle\ViewModel;

class PageViewModel
{
    protected $metas;
    protected $content;
    protected $alternateLinks;

    public function setMetas($metas)
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

    public function setAlternateLinks($alternateLinks)
    {
        $this->alternateLinks = $alternateLinks;
    }

    public function getAlternateLinks()
    {
        return $this->alternateLinks;
    }
}
