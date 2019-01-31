<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161010170604 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, message_key VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, value LONGTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_D4161B962C2AC5D3 (translatable_id), UNIQUE INDEX message_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_translation ADD CONSTRAINT FK_32D017A32C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES message (id) ON DELETE CASCADE');

        $this->addSql("INSERT INTO message VALUES (1, 'app_name'), (2, 'site_name'), (3, 'twitter_name')");
        $this->addSql("INSERT INTO message_translation VALUES (NULL, 1, 'Arquetipo Symfony', 'es')");
        $this->addSql("INSERT INTO message_translation VALUES (NULL, 1, 'Archetype Symfony', 'en')");
        $this->addSql("INSERT INTO message_translation VALUES (NULL, 1, 'Arquetip Symfony', 'ca')");
        $this->addSql("INSERT INTO message_translation VALUES (NULL, 2, 'Arquetipo Symfony', 'es')");
        $this->addSql("INSERT INTO message_translation VALUES (NULL, 2, 'Archetype Symfony', 'en')");
        $this->addSql("INSERT INTO message_translation VALUES (NULL, 2, 'Arquetip Symfony', 'ca')");
        $this->addSql("INSERT INTO message_translation VALUES (NULL, 3, '@runroom', 'es')");
        $this->addSql("INSERT INTO message_translation VALUES (NULL, 3, '@runroom', 'en')");
        $this->addSql("INSERT INTO message_translation VALUES (NULL, 3, '@runroom', 'ca')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE messages_translations DROP FOREIGN KEY FK_32D017A32C2AC5D3');
        $this->addSql('DROP INDEX IDX_32D017A32C2AC5D3 ON messages_translations');
        $this->addSql('DROP TABLE messages_translations');
        $this->addSql('DROP TABLE messages');
    }
}
