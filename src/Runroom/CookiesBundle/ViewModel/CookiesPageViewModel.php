<?php

namespace Runroom\CookiesBundle\ViewModel;

use Runroom\BaseBundle\ViewModel\FormAware;
use Runroom\BaseBundle\ViewModel\FormAwareInterface;
use Runroom\CookiesBundle\Entity\CookiesPage;

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
