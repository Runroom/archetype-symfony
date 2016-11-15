<?php

namespace Archetype\DemoBundle\Controller;

use Archetype\DemoBundle\Service\DemoService;
use Runroom\BaseBundle\Controller\BaseController;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class DemoController extends BaseController
{
    const INDEX_VIEW = 'pages/home.html.twig';
    protected $service;

    public function __construct(
        EngineInterface $renderer,
        DemoService $service
    ) {
        parent::__construct($renderer);
        $this->service = $service;
    }

    public function index()
    {
        $model = $this->service->getDemoViewModel();

        return $this->renderResponse(self::INDEX_VIEW, $model);
    }
}
