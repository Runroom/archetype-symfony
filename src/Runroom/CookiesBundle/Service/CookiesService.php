<?php

namespace Runroom\CookiesBundle\Service;

use Runroom\BaseBundle\Event\PageRenderEvent;
use Runroom\CookiesBundle\ViewModel\CookiesViewModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CookiesService implements EventSubscriberInterface
{
    const TYPE_PERFORMANCE = 'performance_cookies';
    const TYPE_TARGETING = 'targeting_cookies';
    const COOKIE_TARGETING = 'targeting_cookie';
    const COOKIE_PERFORMANCE = 'performance_cookie';

    protected $cookies;
    protected $requestStack;

    public function __construct(
        array $cookies,
        RequestStack $requestStack
    ) {
        $this->cookies = $cookies;
        $this->requestStack = $requestStack;
    }

    public function onPageRender(PageRenderEvent $event): void
    {
        $page = $event->getPageViewModel();
        $page->setCookies($this->buildCookiesViewModel());
        $event->setPageViewModel($page);
    }

    public static function getSubscribedEvents()
    {
        return [
            PageRenderEvent::EVENT_NAME => 'onPageRender',
        ];
    }

    protected function buildCookiesViewModel(): CookiesViewModel
    {
        $model = new CookiesViewModel();
        $model->setPerformanceCookies($this->getCookies(self::TYPE_PERFORMANCE));
        $model->setTargetingCookies($this->getCookies(self::TYPE_TARGETING));

        if ($this->getRequest()->cookies->has(self::COOKIE_PERFORMANCE)) {
            $model->setPerformanceIsAccepted($this->cookieIsAccepted(self::COOKIE_PERFORMANCE));
        }

        if ($this->getRequest()->cookies->has(self::COOKIE_TARGETING)) {
            $model->setTargetingIsAccepted($this->cookieIsAccepted(self::COOKIE_TARGETING));
        }

        return $model;
    }

    protected function getCookies(string $type): array
    {
        $cookies = [];
        foreach ($this->cookies[$type] as $category) {
            $cookies = \array_merge($cookies, $category['cookies'] ?? []);
        }

        return $cookies;
    }

    protected function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    protected function cookieIsAccepted(string $cookieName): bool
    {
        return $this->getRequest()->cookies->get($cookieName) == 'true';
    }
}
