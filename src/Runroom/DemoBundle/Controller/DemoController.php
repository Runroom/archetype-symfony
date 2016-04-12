<?php

namespace Runroom\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class DemoController
{
    protected $renderer;

    const INDEX_VIEW = 'demo/index.html.twig';

    public function __construct(EngineInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function index()
    {
        return $this->renderer->renderResponse(self::INDEX_VIEW, []);
    }
}
