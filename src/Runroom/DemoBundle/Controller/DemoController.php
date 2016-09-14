<?php

namespace Runroom\DemoBundle\Controller;

use Runroom\BaseBundle\Controller\BaseController;
use Runroom\DemoBundle\Service\DemoService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class DemoController extends BaseController
{
    const INDEX_VIEW = 'demo/index.html.twig';
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
