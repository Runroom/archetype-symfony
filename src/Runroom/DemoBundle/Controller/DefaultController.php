<?php

namespace Runroom\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class DefaultController
{
    protected $renderer;

    const INDEX_VIEW = 'DemoBundle:Default:index.html.twig';

    public function __construct(EngineInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function index()
    {
        return $this->renderer->renderResponse(self::INDEX_VIEW, []);
    }
}
