<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Runroom\RenderEventBundle\Event\PageRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

final class LanguageSwitchSubscriber implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private const COOKIE_NAME = 'language_switched';

    /**
     * @param string[] $locales
     */
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly CrawlerDetect $crawlerDetect,
        private readonly array $locales
    ) {
    }

    public function onPageRender(PageRenderEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();

        if (null !== $request && null === $request->cookies->get(self::COOKIE_NAME) && !$this->crawlerDetect->isCrawler()) {
            $browserLocale = $request->getPreferredLanguage($this->locales);
            $alternateLinks = $event->getPageViewModel()->getContext('alternate_links');
            $response = $event->getResponse();

            if (isset($alternateLinks[$browserLocale]) && $request->getLocale() !== $browserLocale) {
                $response = new RedirectResponse($alternateLinks[$browserLocale]);

                $response->headers->setCookie(Cookie::create(self::COOKIE_NAME, 'true'));
                $response->setPrivate();

                $event->setResponse($response);
                $event->stopPropagation();
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PageRenderEvent::EVENT_NAME => ['onPageRender', -1],
        ];
    }
}
