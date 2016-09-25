<?php

namespace Runroom\BaseBundle\Controller;

use Runroom\BaseBundle\Service\StaticPageService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class StaticPageController extends BaseController
{
    const STATIC_PAGE = 'templates/statics.html.twig';

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
