<?php

namespace Runroom\StaticPageBundle\ViewModel;

use Runroom\StaticPageBundle\Entity\StaticPage;

class StaticPageViewModel
{
    protected $staticPage;

    public function setStaticPage(StaticPage $staticPage)
    {
        $this->staticPage = $staticPage;
    }

    public function getStaticPage()
    {
        return $this->staticPage;
    }
}
