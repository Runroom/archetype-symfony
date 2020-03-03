<?php

namespace Runroom\BaseBundle\ViewModel;

use Runroom\CookiesBundle\ViewModel\CookiesViewModel;
use Runroom\RenderEventBundle\ViewModel\PageViewModelInterface;

class PageViewModel implements PageViewModelInterface
{
    protected $metas;
    protected $content;
    protected $alternateLinks;
    protected $staticPages;
    protected $cookiesViewModel;

    public function setMetas(MetaInformationViewModel $metas): void
    {
        $this->metas = $metas;
    }

    public function getMetas(): ?MetaInformationViewModel
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

    public function setStaticPages(array $staticPages): void
    {
        $this->staticPages = $staticPages;
    }

    public function getStaticPages(string ...$locations): array
    {
        return \array_filter($this->staticPages, function ($staticPage) use ($locations) {
            return \in_array($staticPage->getLocation(), $locations);
        });
    }

    public function setCookies(CookiesViewModel $cookiesViewModel): void
    {
        $this->cookiesViewModel = $cookiesViewModel;
    }

    public function getCookies(): ?CookiesViewModel
    {
        return $this->cookiesViewModel;
    }
}
