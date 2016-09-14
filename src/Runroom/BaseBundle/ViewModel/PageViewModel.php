<?php

namespace Runroom\BaseBundle\ViewModel;

class PageViewModel
{
    protected $metas;
    protected $content;
    protected $alternate_links;
    protected $footer_static_pages;

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

    public function setAlternateLinks($alternate_links)
    {
        $this->alternate_links = $alternate_links;
    }

    public function getAlternateLinks()
    {
        return $this->alternate_links;
    }

    public function setFooterStaticPages($footer_static_pages)
    {
        $this->footer_static_pages = $footer_static_pages;
    }

    public function getFooterStaticPages()
    {
        return $this->footer_static_pages;
    }
}
