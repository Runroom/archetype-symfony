<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210831112310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Content migration';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO `user` (`id`, `email`, `roles`, `password`, `enabled`, `created_at`) VALUES (1, 'admin@localhost.com', '[\"ROLE_SUPER_ADMIN\"]', '\$2y\$13\$XmyMMJ/NVDnXz1MFeJxBlOOxCw4ZIRaXlOXJ0MNbMT9jVFlDJOz.m', 1, '2021-08-31 14:25:04');");

        $this->addSql("INSERT INTO meta_information (id, route_name, route) values (1, 'Default', 'default')");
        $this->addSql("INSERT INTO meta_information (id, route_name, route) values (2, 'Not found', '')");
        $this->addSql("INSERT INTO meta_information (id, route_name, route) values (3, 'Basic page', 'runroom.basic_page.route.show')");
        $this->addSql("INSERT INTO meta_information (id, route_name, route) values (4, 'Cookies page', 'runroom.cookies.route.cookies')");

        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (1, 'Archetype Symfony', 'Archetype to start our projects', 'en')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (1, 'Arquetipo de Symfony', 'Arquetipo para empezar nuestros proyectos', 'es')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (1, 'Arquetip de Symfony', 'Arquetip per començar els nostres projectes', 'ca')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (2, '404 | Archetype Symfony', 'Page not found', 'en')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (2, '404 | Arquetipo de Symfony', 'Página no encontrada', 'es')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (2, '404 | Arquetip de Symfony', 'Pàgina no trobada', 'ca')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (3, '[model.basicPage.title] | Archetype Symfony', '[model.basicPage.content]', 'en')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (3, '[model.basicPage.title] | Arquetipo de Symfony', '[model.basicPage.content]', 'es')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (3, '[model.basicPage.title] | Arquetip de Symfony', '[model.basicPage.content]', 'ca')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (4, 'Cookies | Archetype Symfony', 'Cookies settings', 'en')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (4, 'Cookies | Arquetipo de Symfony', 'Configuración de cookies', 'es')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (4, 'Cookies | Arquetip de Symfony', 'Configuració de cookies', 'ca')");

        $this->addSql("INSERT INTO translation (id, translation_key) VALUES (1, 'site_name')");
        $this->addSql("INSERT INTO translation (id, translation_key) VALUES (2, 'twitter_name')");
        $this->addSql("INSERT INTO translation (id, translation_key) VALUES (3, 'privacy_url')");

        $this->addSql("INSERT INTO translation_translation (translatable_id, value, locale) VALUES (1, 'Arquetipo Symfony', 'es')");
        $this->addSql("INSERT INTO translation_translation (translatable_id, value, locale) VALUES (1, 'Archetype Symfony', 'en')");
        $this->addSql("INSERT INTO translation_translation (translatable_id, value, locale) VALUES (1, 'Arquetip Symfony', 'ca')");
        $this->addSql("INSERT INTO translation_translation (translatable_id, value, locale) VALUES (2, '@symfony', 'es')");
        $this->addSql("INSERT INTO translation_translation (translatable_id, value, locale) VALUES (2, '@symfony', 'en')");
        $this->addSql("INSERT INTO translation_translation (translatable_id, value, locale) VALUES (2, '@symfony', 'ca')");
        $this->addSql("INSERT INTO translation_translation (translatable_id, value, locale) VALUES (3, '/politica-de-privacidad', 'es')");
        $this->addSql("INSERT INTO translation_translation (translatable_id, value, locale) VALUES (3, '/politica-de-privacitat', 'ca')");
        $this->addSql("INSERT INTO translation_translation (translatable_id, value, locale) VALUES (3, '/privacy-policy', 'en')");

        $this->addSql("INSERT INTO basic_page (id, meta_information_id, location, publish) VALUES (1, NULL, 'footer', 1)");

        $this->addSql("INSERT INTO basic_page_translation (translatable_id, title, slug, content, locale) VALUES (1, 'Política de privacidad', 'politica-de-privacidad', 'Política de privacidad', 'es')");
        $this->addSql("INSERT INTO basic_page_translation (translatable_id, title, slug, content, locale) VALUES (1, 'Política de privacitat', 'politica-de-privacitat', 'Política de privacitat', 'ca')");
        $this->addSql("INSERT INTO basic_page_translation (translatable_id, title, slug, content, locale) VALUES (1, 'Privacy policy', 'privacy-policy', 'Privacy Policy', 'en')");

        $this->addSql('INSERT INTO cookies_page (id) VALUES (1)');

        $this->addSql("INSERT INTO cookies_page_translation (translatable_id, title, content, locale) VALUES (1, 'Cookie Policy', 'Cookies content', 'en')");
        $this->addSql("INSERT INTO cookies_page_translation (translatable_id, title, content, locale) VALUES (1, 'Política de cookies', 'Cookies content', 'es')");
        $this->addSql("INSERT INTO cookies_page_translation (translatable_id, title, content, locale) VALUES (1, 'Política de cookies', 'Cookies content', 'ca')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM cookies_page_translation');
        $this->addSql('DELETE FROM cookies_page');
        $this->addSql('DELETE FROM basic_page_translation');
        $this->addSql('DELETE FROM basic_page');
        $this->addSql('DELETE FROM translation_translation');
        $this->addSql('DELETE FROM translation');
        $this->addSql('DELETE FROM meta_information_translation');
        $this->addSql('DELETE FROM meta_information');
    }
}
