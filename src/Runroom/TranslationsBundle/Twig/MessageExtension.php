<?php

namespace Runroom\TranslationsBundle\Twig;

use Runroom\TranslationsBundle\Service\MessageService;

class MessageExtension extends \Twig_Extension
{
    private $service;

    public function __construct(MessageService $service) {
        $this->service = $service;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('message', [$this, 'message'], ['is_safe' => ['html']]),
        ];
    }

    public function message($key, $parameters = [], $locale = null)
    {
        return $this->service->message($key, $parameters, $locale);
    }

    public function getName()
    {
        return 'message_extension';
    }
}
