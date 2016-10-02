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

        $this->addSql('CREATE TABLE static_page (id INT AUTO_INCREMENT NOT NULL, meta_information_id INT DEFAULT NULL, location VARCHAR(255) NOT NULL, publish TINYINT(1) NOT NULL, position INT NOT NULL, UNIQUE INDEX UNIQ_8FA4EF952051F018 (meta_information_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery_images (id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, gallery_id INT DEFAULT NULL, position INT NOT NULL, INDEX IDX_429C52C8C53D045F (image), INDEX IDX_429C52C84E7AF8F (gallery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meta_information (id INT AUTO_INCREMENT NOT NULL, image INT DEFAULT NULL, route VARCHAR(255) NOT NULL, route_name VARCHAR(255) NOT NULL, INDEX IDX_81BE2C74C53D045F (image), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entity_meta_information_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_F65116A92C2AC5D3 (translatable_id), UNIQUE INDEX entity_meta_information_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entity_meta_information (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE static_page_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, breadcrumb VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B33A30C9989D9B62 (slug), INDEX IDX_B33A30C92C2AC5D3 (translatable_id), UNIQUE INDEX static_page_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meta_information_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_A00FFF8C2C2AC5D3 (translatable_id), UNIQUE INDEX meta_information_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE static_page ADD CONSTRAINT FK_8FA4EF952051F018 FOREIGN KEY (meta_information_id) REFERENCES entity_meta_information (id)');
        $this->addSql('ALTER TABLE gallery_images ADD CONSTRAINT FK_429C52C8C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE gallery_images ADD CONSTRAINT FK_429C52C84E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('ALTER TABLE meta_information ADD CONSTRAINT FK_81BE2C74C53D045F FOREIGN KEY (image) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE entity_meta_information_translation ADD CONSTRAINT FK_F65116A92C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES entity_meta_information (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE static_page_translation ADD CONSTRAINT FK_B33A30C92C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES static_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meta_information_translation ADD CONSTRAINT FK_A00FFF8C2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES meta_information (id) ON DELETE CASCADE');

        $this->addSql("INSERT INTO meta_information (id, route_name, route) values (1, 'Default', 'default')");
        $this->addSql("INSERT INTO meta_information_translation (translatable_id, title, description, locale) values (1, 'Archetype Symfony', 'Archetype to start our projects', 'en')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE static_page_translation DROP FOREIGN KEY FK_B33A30C92C2AC5D3');
        $this->addSql('ALTER TABLE meta_information_translation DROP FOREIGN KEY FK_A00FFF8C2C2AC5D3');
        $this->addSql('ALTER TABLE static_page DROP FOREIGN KEY FK_8FA4EF952051F018');
        $this->addSql('ALTER TABLE entity_meta_information_translation DROP FOREIGN KEY FK_F65116A92C2AC5D3');
        $this->addSql('ALTER TABLE gallery_images DROP FOREIGN KEY FK_429C52C84E7AF8F');
        $this->addSql('DROP TABLE static_page');
        $this->addSql('DROP TABLE gallery_images');
        $this->addSql('DROP TABLE meta_information');
        $this->addSql('DROP TABLE entity_meta_information_translation');
        $this->addSql('DROP TABLE entity_meta_information');
        $this->addSql('DROP TABLE static_page_translation');
        $this->addSql('DROP TABLE meta_information_translation');
        $this->addSql('DROP TABLE gallery');
    }
}
