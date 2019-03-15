<?php

namespace Runroom\BaseBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class UnescapeExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('unescape', [$this, 'unescape'], ['is_safe' => ['html']]),
        ];
    }

    public function unescape(string $value): string
    {
        return \html_entity_decode($value, ENT_NOQUOTES);
    }
}
