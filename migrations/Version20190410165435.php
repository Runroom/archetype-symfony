<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190410165435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'RunroomCookiesBundle migration';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cookies_page_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_93DF3F4E2C2AC5D3 (translatable_id), UNIQUE INDEX cookies_page_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cookies_page (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cookies_page_translation ADD CONSTRAINT FK_93DF3F4E2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES cookies_page (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cookies_page_translation DROP FOREIGN KEY FK_93DF3F4E2C2AC5D3');
        $this->addSql('DROP TABLE cookies_page_translation');
        $this->addSql('DROP TABLE cookies_page');
    }
}
