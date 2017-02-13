<?php

namespace Runroom\TranslationsBundle\Service;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Translation\TranslatorInterface;

class MessageService
{
    protected $repository;
    protected $translator;

    public function __construct(
        EntityRepository $repository,
        TranslatorInterface $translator
    ) {
        $this->repository = $repository;
        $this->translator = $translator;
    }

    public function message($key, $parameters = [], $locale = null)
    {
        $message = $this->repository->findOneBy(['key' => $key]);

        if (!is_null($message)) {
            $locale = $locale ?: $this->translator->getLocale();
            $message = $message->translate($locale)->getValue();

            return str_replace(array_keys($parameters), array_values($parameters), $message);
        }

        return $this->translator->trans($key, $parameters, null, $locale);
    }
}
