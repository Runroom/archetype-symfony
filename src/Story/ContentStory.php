<?php

declare(strict_types=1);

namespace App\Story;

use App\Factory\UserFactory;
use Runroom\BasicPageBundle\Factory\BasicPageFactory;
use Runroom\BasicPageBundle\Factory\BasicPageTranslationFactory;
use Runroom\CookiesBundle\Factory\CookiesPageFactory;
use Runroom\CookiesBundle\Factory\CookiesPageTranslationFactory;
use Runroom\SeoBundle\Factory\MetaInformationFactory;
use Runroom\SeoBundle\Factory\MetaInformationTranslationFactory;
use Runroom\TranslationBundle\Factory\TranslationFactory;
use Runroom\TranslationBundle\Factory\TranslationTranslationFactory;
use Zenstruck\Foundry\Story;

final class ContentStory extends Story
{
    #[\Override]
    public function build(): void
    {
        // Create User
        UserFactory::createOne([
            'username' => 'admin',
            'roles' => ['ROLE_SUPER_ADMIN'],
            'enabled' => 1,
        ]);

        // Create meta information
        foreach ($this->getMetaInformationData() as $meta) {
            $translations = $meta['translations'];
            $meta['meta']['translations'] = MetaInformationTranslationFactory::new(function () use (&$translations): array {
                $translation = array_pop($translations);
                \assert(\is_array($translation));

                return $translation;
            })->many(\count($translations));
            MetaInformationFactory::createOne($meta['meta']);
        }

        // Create translation
        foreach ($this->getTranslationData() as $translation) {
            $translations = $translation['translations'];
            $translation['translationData']['translations'] = TranslationTranslationFactory::new(function () use (&$translations): array {
                $translation = array_pop($translations);
                \assert(\is_array($translation));

                return $translation;
            })->many(\count($translations));
            TranslationFactory::createOne($translation['translationData']);
        }

        // Create Basic pages
        foreach ($this->getBasicPageData() as $basicPage) {
            $translations = $basicPage['translations'];
            $basicPage['basicPage']['translations'] = BasicPageTranslationFactory::new(function () use (&$translations): array {
                $translation = array_pop($translations);
                \assert(\is_array($translation));

                return $translation;
            })->many(\count($translations));
            BasicPageFactory::createOne($basicPage['basicPage']);
        }

        // Create cookies page
        foreach ($this->getCookiesPageData() as $cookiesPage) {
            $translations = $cookiesPage['translations'];
            $cookiesPage['cookiesPage']['translations'] = CookiesPageTranslationFactory::new(function () use (&$translations): array {
                $translation = array_pop($translations);
                \assert(\is_array($translation));

                return $translation;
            })->many(\count($translations));
            CookiesPageFactory::createOne($cookiesPage['cookiesPage']);
        }
    }

    /**
     * @return array<array{
     *     meta: array{routeName: string, route: string},
     *     translations: array<array{title: string, description: string, locale: string}>
     * }>
     */
    public function getMetaInformationData(): array
    {
        return [
            [
                'meta' => ['routeName' => 'Default', 'route' => 'default'],
                'translations' => [
                    ['title' => 'Archetype Symfony', 'description' => 'Archetype to start our projects', 'locale' => 'en'],
                    ['title' => 'Arquetipo de Symfony', 'description' => 'Arquetipo para empezar nuestros proyectos', 'locale' => 'es'],
                    ['title' => 'Arquetip de Symfony', 'description' => 'Arquetip per començar els nostres projectes', 'locale' => 'ca'],
                ],
            ],
            [
                'meta' => ['routeName' => 'Not found', 'route' => ''],
                'translations' => [
                    ['title' => '404 | Archetype Symfony', 'description' => 'Page not found', 'locale' => 'en'],
                    ['title' => '404 | Arquetipo de Symfony', 'description' => 'Página no encontrada', 'locale' => 'es'],
                    ['title' => '404 | Arquetip de Symfony', 'description' => 'Pàgina no trobada', 'locale' => 'ca'],
                ],
            ],
            [
                'meta' => ['routeName' => 'Basic page', 'route' => 'runroom.basic_page.route.show'],
                'translations' => [
                    ['title' => '[model.basicPage.title] | Archetype Symfony', 'description' => '[model.basicPage.content]', 'locale' => 'en'],
                    ['title' => '[model.basicPage.title] | Arquetipo de Symfony', 'description' => '[model.basicPage.content]', 'locale' => 'es'],
                    ['title' => '[model.basicPage.title] | Arquetip de Symfony', 'description' => '[model.basicPage.content]', 'locale' => 'ca'],
                ],
            ],
            [
                'meta' => ['routeName' => 'Cookies page', 'route' => 'runroom.cookies.route.cookies'],
                'translations' => [
                    ['title' => 'Cookies | Archetype Symfony', 'description' => 'Cookies settings', 'locale' => 'en'],
                    ['title' => 'Cookies | Arquetipo de Symfony', 'description' => 'Configuración de cookies', 'locale' => 'es'],
                    ['title' => 'Cookies | Arquetip de Symfony', 'description' => 'Configuració de cookies', 'locale' => 'ca'],
                ],
            ],
        ];
    }

    /**
     * @return array<array{
     *     translationData: array{key: string},
     *     translations: array<array{value: string, locale: string}>
     * }>
     */
    public function getTranslationData(): array
    {
        return [
            [
                'translationData' => ['key' => 'site_name'],
                'translations' => [
                    ['value' => 'Archetype Symfony', 'locale' => 'en'],
                    ['value' => 'Arquetipo Symfony', 'locale' => 'es'],
                    ['value' => 'Arquetip Symfony', 'locale' => 'ca'],
                ],
            ],
            [
                'translationData' => ['key' => 'twitter_name'],
                'translations' => [
                    ['value' => '@symfony', 'locale' => 'en'],
                    ['value' => '@symfony', 'locale' => 'es'],
                    ['value' => '@symfony', 'locale' => 'ca'],
                ],
            ],
            [
                'translationData' => ['key' => 'privacy_url'],
                'translations' => [
                    ['value' => '/privacy-policy', 'locale' => 'en'],
                    ['value' => '/politica-de-privacidad', 'locale' => 'es'],
                    ['value' => '/politica-de-privacitat', 'locale' => 'ca'],
                ],
            ],
        ];
    }

    /**
     * @return array<array{
     *     basicPage: array{metaInformation: null, location: string, publish: boolean},
     *     translations: array<array{title: string, slug: string, content: string, locale: string}>
     * }>
     */
    public function getBasicPageData(): array
    {
        return [
            [
                'basicPage' => ['metaInformation' => null, 'location' => 'footer', 'publish' => true],
                'translations' => [
                    ['title' => 'Privacy policy', 'slug' => 'privacy-policy', 'content' => 'Privacy Policy', 'locale' => 'en'],
                    ['title' => 'Política de privacidad', 'slug' => 'politica-de-privacidad', 'content' => 'Política de privacidad', 'locale' => 'es'],
                    ['title' => 'Política de privacitat', 'slug' => 'politica-de-privacitat', 'content' => 'Política de privacitat', 'locale' => 'ca'],
                ],
            ],
        ];
    }

    /**
     * @return array<array{
     *     cookiesPage: array{},
     *     translations: array<array{title: string, content: string, locale: string}>
     * }>
     */
    public function getCookiesPageData(): array
    {
        return [
            [
                'cookiesPage' => [],
                'translations' => [
                    ['title' => 'Cookie Policy', 'content' => 'Cookies content', 'locale' => 'en'],
                    ['title' => 'Política de cookies', 'content' => 'Cookies content', 'locale' => 'es'],
                    ['title' => 'Política de cookies', 'content' => 'Cookies content', 'locale' => 'ca'],
                ],
            ],
        ];
    }
}
