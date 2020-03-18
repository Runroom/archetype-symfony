<?php

namespace Runroom\BaseBundle\Service;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FormHandler
{
    protected $formFactory;
    protected $session;

    public function __construct(
        FormFactoryInterface $formFactory,
        SessionInterface $session
    ) {
        $this->formFactory = $formFactory;
        $this->session = $session;
    }

    public function handleForm(string $type, object $object = null): FormInterface
    {
        $form = $this->formFactory->create($type, $object);
        $form->handleRequest();

        if ($form->isSubmitted() && $form->isValid()) {
            $this->session->getFlashBag()->add($form->getName(), 'success');
        }

        return $form;
    }
}
