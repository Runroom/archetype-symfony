<?php

namespace App\Story;

use Runroom\BasicPageBundle\Factory\BasicPageFactory;
use Runroom\CookiesBundle\Factory\CookiesPageFactory;
use Runroom\SeoBundle\Factory\MetaInformationFactory;
use Runroom\TranslationBundle\Factory\TranslationFactory;
use Runroom\UserBundle\Factory\UserFactory;
use Zenstruck\Foundry\Story;

final class BasicStory extends Story
{
    public function build(): void
    {
        // Create User
        UserFactory::createOne([
            'email' => 'admin@localhost.com',
            'roles' => ['ROLE_SUPER_ADMIN'],
            'password' => '\$2y\$13\$XmyMMJ/NVDnXz1MFeJxBlOOxCw4ZIRaXlOXJ0MNbMT9jVFlDJOz.m',
            'enabled' => 1,
            'createdAt' => new \DateTime(),
        ]);

        // Create meta information
        foreach ($this->getMetaInformationData() as $meta) {
            MetaInformationFactory::new($meta['meta'])->withTranslations(['en'], $meta['translation']);
        }

        // Create translation
        foreach ($this->getTranslationData() as $translation) {
            TranslationFactory::new($translation['translationData'])->withTranslations(['en'], $translation['translation']);
        }

        // Create basic page
        BasicPageFactory::new([
            'metaInformation' => null,
            'location' => 'footer',
            'publish' => 1,
        ])->withTranslations(['en'],  [
            'title' => 'Privacy policy',
            'slug' => 'privacy-policy',
            'content' => 'Privacy Policy',
        ]);

        // Create cookie
        CookiesPageFactory::new()->withTranslations(['en'], [
            'title' => 'Cookie Policy',
            'content' => 'Cookies content',
        ]);
    }

    public function getMetaInformationData(): array {
        return [
            [
                'meta' => ['routeName' => 'Default', 'route' => 'default'],
                'translation' => ['title' => 'Archetype Symfony', 'description' => 'Archetype to start our projects'],
            ],
            [
                'meta' => ['routeName' => 'Not found', 'route' => ''],
                'translation' => ['title' => '404 | Archetype Symfony', 'description' => 'Page not found'],
            ],
            [
                'meta' => ['routeName' => 'Basic page', 'route' => 'runroom.basic_page.route.show'],
                'translation' => ['title' => '[model.basicPage.title] | Archetype Symfony', 'description' => '[model.basicPage.content]'],
            ],
            [
                'meta' => ['routeName' => 'Cookies page', 'route' => 'runroom.cookies.route.cookies'],
                'translation' => ['title' => 'Cookies | Archetype Symfony', 'description' => 'Cookies settings'],
            ],
        ];
    }

    public function getTranslationData(): array {
        return [
            [
                'translationData' => ['translation_key' => 'site_name'],
                'translation' => ['value' => 'Archetype Symfony'],
            ],
            [
                'translationData' => ['translation_key' => 'twitter_name'],
                'translation' => ['value' => '@symfony'],
            ],
            [
                'translationData' => ['translation_key' => 'privacy_url'],
                'translation' => ['value' => '/privacy-policy'],
            ],
        ];
    }
}
