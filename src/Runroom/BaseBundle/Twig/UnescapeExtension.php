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

    public function unescape($value)
    {
        return html_entity_decode($value, ENT_NOQUOTES);
    }
}
