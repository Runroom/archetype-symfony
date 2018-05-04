<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\ViewModel\BasicFormViewModel;
use Runroom\BaseBundle\ViewModel\FormAwareInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FormHandler
{
    protected $formFactory;
    protected $eventDispatcher;
    protected $requestStack;
    protected $session;

    public function __construct(
        FormFactoryInterface $formFactory,
        EventDispatcherInterface $eventDispatcher,
        RequestStack $requestStack,
        SessionInterface $session
    ) {
        $this->formFactory = $formFactory;
        $this->eventDispatcher = $eventDispatcher;
        $this->requestStack = $requestStack;
        $this->session = $session;
    }

    public function handleForm(string $type, FormAwareInterface $model = null): FormAwareInterface
    {
        $form = $this->formFactory->create($type);
        $form->setData($this->getDataObject($form));
        $form->handleRequest($this->requestStack->getCurrentRequest());

        $model = $model ?? new BasicFormViewModel();
        $model->setForm($form);

        if ($model->formIsValid()) {
            $this->eventDispatcher->dispatch(
                'form.' . $form->getName() . '.event.success',
                new GenericEvent($model)
            );

            if ($model->getIsSuccess()) {
                $this->session->getFlashBag()->add($form->getName(), 'success');
            }
        }

        return $model;
    }

    private function getDataObject(FormInterface $form)
    {
        $dataClass = $form->getConfig()->getDataClass();

        return $dataClass && \is_null($form->getData()) ? new $dataClass() : $form->getData();
    }
}
