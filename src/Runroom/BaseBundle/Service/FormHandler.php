<?php

namespace Runroom\BaseBundle\Service;

use Runroom\BaseBundle\ViewModel\BasicFormViewModel;
use Runroom\BaseBundle\ViewModel\FormAwareInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class FormHandler
{
    protected $formFactory;
    protected $eventDispatcher;
    protected $requestStack;

    public function __construct(
        FormFactoryInterface $formFactory,
        EventDispatcherInterface $eventDispatcher,
        RequestStack $requestStack
    ) {
        $this->formFactory = $formFactory;
        $this->eventDispatcher = $eventDispatcher;
        $this->requestStack = $requestStack;
    }

    public function handleForm(string $type, FormAwareInterface $model = null): FormAwareInterface
    {
        $form = $this->formFactory->create($type);
        $form->handleRequest($this->requestStack->getCurrentRequest());

        $model = $model ?? new BasicFormViewModel();
        $model->setForm($form);

        if ($model->formIsValid()) {
            $event = new GenericEvent($model);

            $this->eventDispatcher->dispatch(
                'form.' . $form->getName() . '.event.success',
                $event
            );

            return $event->getSubject();
        }

        return $model;
    }
}
