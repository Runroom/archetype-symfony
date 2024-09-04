<?php

declare(strict_types=1);

namespace App\EventListener;

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
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
        private array $locales,
    ) {
    }

    public function __invoke(ResponseEvent $event): void
    {
        $request = $event->getRequest();

        if (
            !$event->isMainRequest()
            || null !== $request->cookies->get(self::COOKIE_NAME)
            || $this->crawlerDetect->isCrawler($request->headers->get('User-Agent'))
        ) {
            return;
        }

        $preferredLocale = $request->getPreferredLanguage($this->locales);
        $needsRedirection = '/' === $request->getPathInfo()
            && $request->getLocale() !== $preferredLocale;

        $response = $needsRedirection ?
            new RedirectResponse(
                $this->urlGenerator->generate($this->homeRoute, ['_locale' => $preferredLocale])
            )
            : $event->getResponse();

        $response->headers->setCookie(Cookie::create(self::COOKIE_NAME, 'true'));
        $response->setPrivate();

        $event->setResponse($response);
    }
}
