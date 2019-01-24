<?php

namespace Runroom\CookiesBundle\Service;

use Runroom\BaseBundle\Service\FormHandler;
use Runroom\CookiesBundle\Form\Type\CookiesFormType;
use Runroom\CookiesBundle\Repository\CookiesPageRepository;
use Runroom\CookiesBundle\ViewModel\CookiesPageViewModel;

class CookiesPageService
{
    protected $repository;
    protected $handler;
    protected $cookies;

    public function __construct(CookiesPageRepository $repository, FormHandler $handler, array $cookies)
    {
        $this->repository = $repository;
        $this->handler = $handler;
        $this->cookies = $cookies;
    }

    public function getViewModel(): CookiesPageViewModel
    {
        $viewModel = new CookiesPageViewModel();
        $viewModel
            ->setCookiesPage($this->repository->find())
            ->setCookies($this->cookies);

        return $this->handler->handleForm(CookiesFormType::class, $viewModel);
    }
}
