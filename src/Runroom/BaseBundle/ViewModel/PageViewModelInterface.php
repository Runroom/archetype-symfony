<?php

namespace Runroom\BaseBundle\ViewModel;

use Runroom\CookiesBundle\ViewModel\CookiesViewModel;

interface PageViewModelInterface
{
    public function setMetas(MetaInformationViewModel $metas): void;

    public function getMetas(): ?MetaInformationViewModel;

    public function setContent($content): void;

    public function getContent();

    public function setAlternateLinks(array $alternateLinks): void;

    public function getAlternateLinks(): ?array;

    public function setStaticPages(array $staticPages): void;

    public function getStaticPages(string ...$locations): array;

    public function setCookies(CookiesViewModel $performanceCookies): void;

    public function getCookies(): ?CookiesViewModel;

    public function setIsInternalIp(bool $isInternalIp): void;

    public function getIsInternalIp(): ?bool;
}
