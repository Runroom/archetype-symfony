<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161010170604 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, message_key VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages_translations (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, value LONGTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_32D017A32C2AC5D3 (translatable_id), UNIQUE INDEX messages_translations_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE messages_translations ADD CONSTRAINT FK_32D017A32C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES messages (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE messages_translations DROP FOREIGN KEY FK_32D017A32C2AC5D3');
        $this->addSql('DROP INDEX IDX_32D017A32C2AC5D3 ON messages_translations');
        $this->addSql('DROP TABLE messages_translations');
        $this->addSql('DROP TABLE messages');
    }
}
