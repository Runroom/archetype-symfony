<?php

namespace Runroom\BaseBundle\EventSubscriber;

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Runroom\RenderEventBundle\Event\PageRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class LanguageSwitchSubscriber implements EventSubscriberInterface
{
    protected const COOKIE_NAME = 'language_switched';

    private $requestStack;
    private $crawlerDetect;
    private $locales;

    public function __construct(
        RequestStack $requestStack,
        CrawlerDetect $crawlerDetect,
        array $locales
    ) {
        $this->requestStack = $requestStack;
        $this->crawlerDetect = $crawlerDetect;
        $this->locales = $locales;
    }

    public function onPageRender(PageRenderEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();

        if (\is_null($request->cookies->get(self::COOKIE_NAME)) && !$this->crawlerDetect->isCrawler()) {
            $browserLocale = $request->getPreferredLanguage($this->locales);
            $alternateLinks = $event->getPageViewModel()->getAlternateLinks();
            $response = $event->getResponse();

            if (isset($alternateLinks[$browserLocale]) && $request->getLocale() !== $browserLocale) {
                $response = new RedirectResponse($alternateLinks[$browserLocale]);

                $event->setResponse($response);
                $event->stopPropagation();
            }

            $response->headers->setCookie(Cookie::create(self::COOKIE_NAME, 'true'));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            PageRenderEvent::EVENT_NAME => ['onPageRender', -1],
        ];
    }
}
