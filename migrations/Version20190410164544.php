<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190410164544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'RunroomSeoBundle migration';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE entity_meta_information (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meta_information (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, route VARCHAR(255) NOT NULL, route_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_81BE2C742C42079 (route), INDEX IDX_81BE2C743DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entity_meta_information_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_F65116A92C2AC5D3 (translatable_id), UNIQUE INDEX entity_meta_information_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meta_information_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_A00FFF8C2C2AC5D3 (translatable_id), UNIQUE INDEX meta_information_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meta_information ADD CONSTRAINT FK_81BE2C743DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE entity_meta_information_translation ADD CONSTRAINT FK_F65116A92C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES entity_meta_information (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meta_information_translation ADD CONSTRAINT FK_A00FFF8C2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES meta_information (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE entity_meta_information_translation DROP FOREIGN KEY FK_F65116A92C2AC5D3');
        $this->addSql('ALTER TABLE meta_information_translation DROP FOREIGN KEY FK_A00FFF8C2C2AC5D3');
        $this->addSql('DROP TABLE entity_meta_information');
        $this->addSql('DROP TABLE meta_information');
        $this->addSql('DROP TABLE entity_meta_information_translation');
        $this->addSql('DROP TABLE meta_information_translation');
    }
}
