<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171122151544 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE static_page ADD location VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_B33A30C9989D9B62 ON static_page_translation');

        $this->addSql("INSERT INTO message VALUES (4, 'privacy_url')");
        $this->addSql("INSERT INTO message_translation VALUES (NULL, 4, '/politica-de-privacidad', 'es')");
        $this->addSql("INSERT INTO message_translation VALUES (NULL, 4, '/politica-de-privacitat', 'ca')");
        $this->addSql("INSERT INTO message_translation VALUES (NULL, 4, '/privacy-policy', 'en')");

        $this->addSql("INSERT INTO static_page VALUES (1, NULL, 1, 'footer')");
        $this->addSql("INSERT INTO static_page_translation VALUES (NULL, 1, 'Política de privacidad', 'politica-de-privacidad', 'Política de privacidad', 'es')");
        $this->addSql("INSERT INTO static_page_translation VALUES (NULL, 1, 'Política de privacitat', 'politica-de-privacitat', 'Política de privacitat', 'ca')");
        $this->addSql("INSERT INTO static_page_translation VALUES (NULL, 1, 'Privacy policy', 'privacy-policy', 'Privacy Policy', 'en')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_B33A30C9989D9B62 ON static_page_translation (slug)');
        $this->addSql('ALTER TABLE static_page DROP location');
        $this->addSql('DELETE FROM message_translation WHERE translatable_id = 4');
        $this->addSql('DELETE FROM message WHERE id = 4');
        $this->addSql('DELETE FROM static_page_translation WHERE translatable_id = 1');
        $this->addSql('DELETE FROM static_page WHERE id = 1');
    }
}
