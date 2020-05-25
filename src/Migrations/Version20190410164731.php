<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190410164731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'RunroomStaticPageBundle migration';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE static_page_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_B33A30C92C2AC5D3 (translatable_id), INDEX IDX_B33A30C9989D9B62 (slug), UNIQUE INDEX static_page_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE static_page (id INT AUTO_INCREMENT NOT NULL, meta_information_id INT DEFAULT NULL, location VARCHAR(255) NOT NULL, publish TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8FA4EF952051F018 (meta_information_id), INDEX IDX_8FA4EF95B894CC41 (publish), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE static_page_translation ADD CONSTRAINT FK_B33A30C92C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES static_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE static_page ADD CONSTRAINT FK_8FA4EF952051F018 FOREIGN KEY (meta_information_id) REFERENCES entity_meta_information (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE static_page_translation DROP FOREIGN KEY FK_B33A30C92C2AC5D3');
        $this->addSql('DROP TABLE static_page_translation');
        $this->addSql('DROP TABLE static_page');
    }
}
