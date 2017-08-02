<?php

namespace Runroom\BaseBundle\Twig;

class UnescapeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('unescape', [$this, 'unescape'], ['is_safe' => ['html']]),
        ];
    }

    public function unescape(string $value): string
    {
        return html_entity_decode($value, ENT_NOQUOTES);
    }
}
