<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190410164731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'RunroomBasicPageBundle migration';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE basic_page_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_2349B9E62C2AC5D3 (translatable_id), INDEX IDX_2349B9E6989D9B62 (slug), UNIQUE INDEX basic_page_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE basic_page (id INT AUTO_INCREMENT NOT NULL, meta_information_id INT DEFAULT NULL, location VARCHAR(255) NOT NULL, publish TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_401CFA4B2051F018 (meta_information_id), INDEX IDX_401CFA4BB894CC41 (publish), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE basic_page_translation ADD CONSTRAINT FK_B33A30C92C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES basic_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE basic_page ADD CONSTRAINT FK_8FA4EF952051F018 FOREIGN KEY (meta_information_id) REFERENCES entity_meta_information (id)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE basic_page_translation DROP FOREIGN KEY FK_B33A30C92C2AC5D3');
        $this->addSql('DROP TABLE basic_page_translation');
        $this->addSql('DROP TABLE basic_page');
    }
}
