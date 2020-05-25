<?php

namespace Runroom\CookiesBundle\ViewModel;

use Runroom\CookiesBundle\Entity\CookiesPage;
use Runroom\FormHandlerBundle\ViewModel\FormAware;
use Runroom\FormHandlerBundle\ViewModel\FormAwareInterface;

class CookiesPageViewModel implements FormAwareInterface
{
    use FormAware;

    protected $cookiesPage;
    protected $cookies = [];

    public function setCookiesPage(CookiesPage $cookiesPage): self
    {
        $this->cookiesPage = $cookiesPage;

        return $this;
    }

    public function getCookiesPage(): ?CookiesPage
    {
        return $this->cookiesPage;
    }

    public function setCookies(array $cookies): self
    {
        $this->cookies = $cookies;

        return $this;
    }

    public function getCookies(): array
    {
        return $this->cookies;
    }
}
