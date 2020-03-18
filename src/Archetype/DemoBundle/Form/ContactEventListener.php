<?php

namespace Archetype\DemoBundle\Form;

use Archetype\DemoBundle\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ContactEventListener implements EventSubscriberInterface
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onSubmit(FormEvent $event)
    {
        $model = $event->getData();

        $contact = new Contact();
        $contact->setName($model->getName());
        $contact->setEmail($model->getEmail());
        $contact->setPhone($model->getPhone());
        $contact->setSubject($model->getSubject());
        $contact->setType($model->getType());
        $contact->setPreferences($model->getPreferences());
        $contact->setComment($model->getComment());
        $contact->setNewsletter($model->getNewsletter());
        $contact->setPrivacyPolicy($model->getPrivacyPolicy());

        $this->entityManager->persist($contact);
        $this->entityManager->flush();
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::SUBMIT => 'onSubmit',
        ];
    }
}
