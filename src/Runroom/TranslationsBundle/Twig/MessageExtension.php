<?php

namespace Runroom\TranslationsBundle\Twig;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Translation\TranslatorInterface;

class MessageExtension extends \Twig_Extension
{
    private $repository;
    private $translator;

    public function __construct(
        EntityRepository $repository,
        TranslatorInterface $translator
    ) {
        $this->repository = $repository;
        $this->translator = $translator;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'getMessageValue',
                [$this, 'getMessageValue'],
                ['is_safe' => ['html']]
            )
        ];
    }

    public function getMessageValue($key, $locale)
    {
        $value = $this->repository->findOneBy(['key' => $key]);

        if (is_null($value)) {
            $value = $this->translator->trans($key, [], null, $locale);
            $value = strcmp($value, $key) === 0 ? '' : $value;
        } else {
            $value = $value->translate($locale)->getValue();
            $value = str_replace(['<p>', '</p>'], '', $value);
        }

        return $value;
    }

    public function getName()
    {
        return 'message_extension';
    }
}
