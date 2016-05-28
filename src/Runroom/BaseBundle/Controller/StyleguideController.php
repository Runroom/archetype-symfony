<?php

namespace Runroom\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class StyleguideController
{
    const STYLEGUIDE_VIEW = 'styleguide/index.html.twig';
    protected $renderer;

    public function __construct(EngineInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function index()
    {
        return $this->renderer->renderResponse(self::STYLEGUIDE_VIEW, []);
    }
}
