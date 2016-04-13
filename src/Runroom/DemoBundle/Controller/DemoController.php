<?php

namespace Runroom\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use Runroom\DemoBundle\Service\DemoService;

class DemoController
{
    protected $renderer;
    protected $service;

    const INDEX_VIEW = 'demo/index.html.twig';

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
            'model' => $model
        ]);
    }
}
