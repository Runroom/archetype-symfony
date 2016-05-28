<?php

namespace Runroom\DemoBundle\Controller;

use Runroom\DemoBundle\Service\DemoService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class DemoController
{
    const INDEX_VIEW = 'demo/index.html.twig';
    protected $renderer;
    protected $service;

    public function __construct(
        EngineInterface $renderer,
        DemoService $service
    ) {
        $this->renderer = $renderer;
        $this->service = $service;
    }

    public function index()
    {
        $model = $this->service->getDemoViewModel();

        return $this->renderer->renderResponse(self::INDEX_VIEW, [
            'model' => $model,
        ]);
    }
}
