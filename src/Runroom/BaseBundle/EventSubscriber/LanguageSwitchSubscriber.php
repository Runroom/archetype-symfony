<?php

namespace Runroom\BaseBundle\EventSubscriber;

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Runroom\BaseBundle\Event\PageRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class LanguageSwitchSubscriber implements EventSubscriberInterface
{
    const COOKIE_NAME = 'language_switched';

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

    public function onPageRender(PageRenderEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request->cookies->get(self::COOKIE_NAME, false) && !$this->crawlerDetect->isCrawler()) {
            $browserLocale = $request->getPreferredLanguage($this->locales);
            $alternateLinks = $event->getPageViewModel()->getAlternateLinks();
            $response = $event->getResponse();

            if (isset($alternateLinks[$browserLocale]) && $request->getLocale() !== $browserLocale) {
                $response = new RedirectResponse($alternateLinks[$browserLocale]);
                $event->stopPropagation();
            }

            $response->headers->setCookie(new Cookie(self::COOKIE_NAME, true));
            $event->setResponse($response);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            PageRenderEvent::EVENT_NAME => ['onPageRender', -1],
        ];
    }
}
