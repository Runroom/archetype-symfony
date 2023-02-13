<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230210091509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu ADD root_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9379066886 FOREIGN KEY (root_id) REFERENCES menu_item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D053A9379066886 ON menu (root_id)');
        $this->addSql('DROP INDEX uniq_d754d550ccd7e912');
        $this->addSql('CREATE INDEX IDX_D754D550CCD7E912 ON menu_item (menu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_D754D550CCD7E912');
        $this->addSql('CREATE UNIQUE INDEX uniq_d754d550ccd7e912 ON menu_item (menu_id)');
        $this->addSql('ALTER TABLE menu DROP CONSTRAINT FK_7D053A9379066886');
        $this->addSql('DROP INDEX UNIQ_7D053A9379066886');
        $this->addSql('ALTER TABLE menu DROP root_id');
    }
}
