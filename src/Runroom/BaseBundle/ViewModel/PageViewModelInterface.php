<?php

namespace Runroom\BaseBundle\ViewModel;

use Runroom\BaseBundle\Entity\MetaInformation;

interface PageViewModelInterface
{
    public function setMetas(MetaInformation $metas): void;

    public function getMetas(): ?MetaInformation;

    public function setContent($content): void;

    public function getContent();

    public function setAlternateLinks(array $alternateLinks): void;

    public function getAlternateLinks(): ?array;
}
