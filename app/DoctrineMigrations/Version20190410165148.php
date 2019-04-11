<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190410165148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'RunroomTranslationsBundle migration';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, value LONGTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_D4161B962C2AC5D3 (translatable_id), UNIQUE INDEX message_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, message_key VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B6BD307FA3A52145 (message_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_translation ADD CONSTRAINT FK_D4161B962C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES message (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message_translation DROP FOREIGN KEY FK_D4161B962C2AC5D3');
        $this->addSql('DROP TABLE message_translation');
        $this->addSql('DROP TABLE message');
    }
}
