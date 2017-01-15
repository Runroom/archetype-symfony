<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160914151650 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE meta_information (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, route VARCHAR(255) NOT NULL, route_name VARCHAR(255) NOT NULL, INDEX IDX_81BE2C743DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meta_information_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_A00FFF8C2C2AC5D3 (translatable_id), UNIQUE INDEX meta_information_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entity_meta_information (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entity_meta_information_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_F65116A92C2AC5D3 (translatable_id), UNIQUE INDEX entity_meta_information_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meta_information ADD CONSTRAINT FK_81BE2C74C53D045F FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE meta_information_translation ADD CONSTRAINT FK_A00FFF8C2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES meta_information (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entity_meta_information_translation ADD CONSTRAINT FK_F65116A92C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES entity_meta_information (id) ON DELETE CASCADE');

        $this->addSql("INSERT INTO meta_information (id, route_name, route) values (1, 'Default', 'default')");
        $this->addSql("INSERT INTO meta_information (id, route_name, route) values (2, 'Not found', '')");
        $this->addSql("INSERT INTO meta_information (id, route_name, route) values (3, 'Static page', 'runroom.static_page.route.static.static')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (1, 'Archetype Symfony', 'Archetype to start our projects', 'en')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (2, '404 | Archetype Symfony', 'Page not found', 'en')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (3, '{title} | Archetype Symfony', '{content}', 'en')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE meta_information_translation DROP FOREIGN KEY FK_A00FFF8C2C2AC5D3');
        $this->addSql('ALTER TABLE entity_meta_information_translation DROP FOREIGN KEY FK_F65116A92C2AC5D3');
        $this->addSql('DROP TABLE meta_information');
        $this->addSql('DROP TABLE entity_meta_information_translation');
        $this->addSql('DROP TABLE entity_meta_information');
        $this->addSql('DROP TABLE meta_information_translation');
    }
}
