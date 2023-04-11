<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209162442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu DROP CONSTRAINT fk_7d053a9379066886');
        $this->addSql('DROP INDEX uniq_7d053a9379066886');
        $this->addSql('ALTER TABLE menu DROP root_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu ADD root_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT fk_7d053a9379066886 FOREIGN KEY (root_id) REFERENCES menu_item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_7d053a9379066886 ON menu (root_id)');
    }
}
