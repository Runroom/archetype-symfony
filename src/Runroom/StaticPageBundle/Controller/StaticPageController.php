<?php

namespace Runroom\StaticPageBundle\Controller;

use Runroom\BaseBundle\Controller\BaseController;
use Runroom\StaticPageBundle\Service\StaticPageService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class StaticPageController extends BaseController
{
    const STATIC_PAGE = 'pages/static.html.twig';

    protected $service;

    public function __construct(
        EngineInterface $renderer,
        StaticPageService $service
    ) {
        parent::__construct($renderer);
        $this->service = $service;
    }

    public function staticPage($static_page_slug)
    {
        $model = $this->service->getStaticPageViewModel($static_page_slug);

        return $this->renderResponse(self::STATIC_PAGE, $model);
    }
}
