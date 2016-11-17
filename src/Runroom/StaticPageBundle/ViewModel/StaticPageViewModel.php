<?php

namespace Runroom\StaticPageBundle\ViewModel;

use Runroom\StaticPageBundle\Entity\StaticPage;

class StaticPageViewModel
{
    protected $static_page;

    public function setStaticPage(StaticPage $static_page)
    {
        $this->static_page = $static_page;
    }

    public function getStaticPage()
    {
        return $this->static_page;
    }
}
