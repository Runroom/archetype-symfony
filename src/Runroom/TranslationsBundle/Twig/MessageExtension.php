<?php

namespace Runroom\TranslationsBundle\Twig;

use Runroom\TranslationsBundle\Service\MessageService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MessageExtension extends AbstractExtension
{
    protected $service;

    public function __construct(MessageService $service)
    {
        $this->service = $service;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('message', [$this, 'message'], ['is_safe' => ['html']]),
        ];
    }

    public function message(string $key, array $parameters = [], string $locale = null): string
    {
        return $this->service->message($key, $parameters, $locale);
    }
}
