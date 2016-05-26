<?php

namespace Runroom\DemoBundle\Controller;

use Runroom\DemoBundle\Service\DemoService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

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
            'model' => $model,
        ]);
    }
}
