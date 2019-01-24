<?php

namespace Runroom\BaseBundle\ViewModel;

class PageViewModel implements PageViewModelInterface
{
    protected $metas;
    protected $content;
    protected $alternateLinks;
    protected $staticPages;
    protected $cookiesViewModel;
    protected $isInternalIp;

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

    public function setCookies(CookiesViewModelInterface $cookiesViewModel): void
    {
        $this->cookiesViewModel = $cookiesViewModel;
    }

    public function getCookies(): ?CookiesViewModelInterface
    {
        return $this->cookiesViewModel;
    }

    public function setIsInternalIp(bool $isInternalIp): void
    {
        $this->isInternalIp = $isInternalIp;
    }

    public function getIsInternalIp(): ?bool
    {
        return $this->isInternalIp;
    }
}
