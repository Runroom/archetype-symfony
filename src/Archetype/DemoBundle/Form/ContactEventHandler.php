<?php

namespace Archetype\DemoBundle\Form;

use Archetype\DemoBundle\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class ContactEventHandler implements EventSubscriberInterface
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onContactSuccess(GenericEvent $event)
    {
        $model = $event->getSubject()->getForm()->getData();

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
            'form.contact_form.event.success' => 'onContactSuccess',
        ];
    }
}
