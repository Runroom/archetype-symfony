<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190102095238 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cookies_page (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cookies_page_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_93DF3F4E2C2AC5D3 (translatable_id), UNIQUE INDEX cookies_page_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cookies_page_translation ADD CONSTRAINT FK_93DF3F4E2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES cookies_page (id) ON DELETE CASCADE');

        $this->addSql('INSERT INTO cookies_page (id) VALUES (1)');
        $this->addSql("INSERT INTO cookies_page_translation (translatable_id, title, content, locale) VALUES (1, 'Cookie Policy', 'Cookies content', 'en')");
        $this->addSql("INSERT INTO cookies_page_translation (translatable_id, title, content, locale) VALUES (1, 'Política de cookies', 'Cookies content', 'es')");
        $this->addSql("INSERT INTO cookies_page_translation (translatable_id, title, content, locale) VALUES (1, 'Política de cookies', 'Cookies content', 'ca')");

        $this->addSql("INSERT INTO meta_information (id, route_name, route) values (4, 'Cookies page', 'runroom.cookies.route.cookies')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (4, 'Cookies | Archetype Symfony', 'Cookies settings', 'en')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (4, 'Cookies | Arquetipo de Symfony', 'Configuración de cookies', 'es')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (4, 'Cookies | Arquetip de Symfony', 'Configuració de cookies', 'ca')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cookies_page_translation DROP FOREIGN KEY FK_93DF3F4E2C2AC5D3');
        $this->addSql('DROP TABLE cookies_page');
        $this->addSql('DROP TABLE cookies_page_translation');
    }
}
