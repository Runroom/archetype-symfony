<?php

namespace Runroom\CookiesBundle\Service;

use Runroom\CookiesBundle\ViewModel\CookiesViewModel;
use Runroom\RenderEventBundle\Event\PageRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CookiesService implements EventSubscriberInterface
{
    private const TYPE_PERFORMANCE = 'performance_cookies';
    private const TYPE_TARGETING = 'targeting_cookies';

    /** @var array */
    private $cookies;

    public function __construct(array $cookies)
    {
        $this->cookies = $cookies;
    }

    public function onPageRender(PageRenderEvent $event): void
    {
        $page = $event->getPageViewModel();
        $page->addContext('cookies', $this->buildCookiesViewModel());
        $event->setPageViewModel($page);
    }

    public static function getSubscribedEvents()
    {
        return [
            PageRenderEvent::EVENT_NAME => 'onPageRender',
        ];
    }

    private function buildCookiesViewModel(): CookiesViewModel
    {
        $model = new CookiesViewModel();
        $model->setPerformanceCookies($this->getCookies(self::TYPE_PERFORMANCE));
        $model->setTargetingCookies($this->getCookies(self::TYPE_TARGETING));

        return $model;
    }

    private function getCookies(string $type): array
    {
        $cookies = [];
        foreach ($this->cookies[$type] as $category) {
            $cookies = array_merge($cookies, $category['cookies'] ?? []);
        }

        return $cookies;
    }
}
