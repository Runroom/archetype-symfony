<?php

namespace Runroom\TranslationsBundle\Service;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Translation\TranslatorInterface;

class MessageService
{
    protected $repository;
    protected $translator;

    public function __construct(EntityRepository $repository, TranslatorInterface $translator)
    {
        $this->repository = $repository;
        $this->translator = $translator;
    }

    public function message(string $key, array $parameters = [], string $locale = null): string
    {
        $message = $this->repository->findOneBy(['key' => $key]);

        if (!\is_null($message)) {
            return \strtr($message->translate($locale)->getValue(), $parameters);
        }

        return $this->translator->trans($key, $parameters, null, $locale);
    }
}
