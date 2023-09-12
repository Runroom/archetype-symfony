<?php

declare(strict_types=1);

namespace App\EventListener;

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsEventListener]
final readonly class LanguageSwitchListener
{
    /**
     * @var string
     */
    private const COOKIE_NAME = 'language_switched';

    /**
     * @param string[] $locales
     */
    public function __construct(
        private CrawlerDetect $crawlerDetect,
        private UrlGeneratorInterface $urlGenerator,
        private string $homeRoute,
        private array $locales
    ) {
    }

    public function __invoke(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $browserLocale = $request->getPreferredLanguage($this->locales);

        if (
            !$event->isMainRequest()
            || '/' !== $request->getPathInfo()
            || null !== $request->cookies->get(self::COOKIE_NAME)
            || $this->crawlerDetect->isCrawler()
            || $request->getLocale() === $browserLocale
        ) {
            return;
        }

        $response = new RedirectResponse(
            $this->urlGenerator->generate($this->homeRoute, ['_locale' => $browserLocale])
        );

        $response->headers->setCookie(Cookie::create(self::COOKIE_NAME, 'true'));
        $response->setPrivate();

        $event->setResponse($response);
        $event->stopPropagation();
    }
}
