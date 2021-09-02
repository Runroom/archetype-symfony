<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190410165148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'RunroomTranslationBundle migration';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE translation_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, value LONGTEXT DEFAULT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_2F770F6E2C2AC5D3 (translatable_id), UNIQUE INDEX translation_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translation (id INT AUTO_INCREMENT NOT NULL, translation_key VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B469456FAADCBD56 (translation_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE translation_translation ADD CONSTRAINT FK_D4161B962C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES translation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE translation_translation DROP FOREIGN KEY FK_D4161B962C2AC5D3');
        $this->addSql('DROP TABLE translation_translation');
        $this->addSql('DROP TABLE translation');
    }
}
