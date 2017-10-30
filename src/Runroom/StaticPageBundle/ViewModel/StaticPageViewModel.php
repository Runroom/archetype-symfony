<?php

namespace Runroom\StaticPageBundle\ViewModel;

use Runroom\StaticPageBundle\Entity\StaticPage;

class StaticPageViewModel
{
    protected $staticPage;

    public function setStaticPage(StaticPage $staticPage): void
    {
        $this->staticPage = $staticPage;
    }

    public function getStaticPage(): ?StaticPage
    {
        return $this->staticPage;
    }
}
