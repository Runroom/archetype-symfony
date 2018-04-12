<?php

namespace Runroom\BaseBundle\ViewModel;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

interface FormAwareInterface
{
    public function setForm(FormInterface $form): void;

    public function getForm(): FormInterface;

    public function setIsSuccess(bool $isSuccess): void;

    public function getIsSuccess(): bool;

    public function getFormView(): FormView;

    public function formIsValid(): bool;
}
