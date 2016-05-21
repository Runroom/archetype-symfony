<?php

namespace Runroom\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class StyleguideController
{
    protected $renderer;

    const STYLEGUIDE_VIEW = 'demo/index.html.twig';

    public function __construct(RenderInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function indexAction()
    {
        return $this->renderer->renderResponse(self::STYLEGUIDE_VIEW, []);
    }
}
