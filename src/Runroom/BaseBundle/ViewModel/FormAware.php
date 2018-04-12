<?php

namespace Runroom\BaseBundle\ViewModel;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

trait FormAware
{
    protected $form;
    protected $formView;
    protected $isSuccess;

    public function setForm(FormInterface $form): void
    {
        $this->form = $form;
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }

    public function setIsSuccess(bool $isSuccess): void
    {
        $this->isSuccess = $isSuccess;
    }

    public function getIsSuccess(): bool
    {
        if (\is_null($this->isSuccess)) {
            $this->isSuccess = $this->formIsValid();
        }

        return $this->isSuccess;
    }

    public function getFormView(): FormView
    {
        if (\is_null($this->formView)) {
            $this->formView = $this->form->createView();
        }

        return $this->formView;
    }

    public function formIsValid(): bool
    {
        return $this->form->isSubmitted() && $this->form->isValid();
    }
}
