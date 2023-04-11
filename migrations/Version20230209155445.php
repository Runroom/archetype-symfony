<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209155445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE menu_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE menu_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE menu (id INT NOT NULL, root_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D053A9379066886 ON menu (root_id)');
        $this->addSql('CREATE TABLE menu_item (id INT NOT NULL, parent_id INT DEFAULT NULL, menu_id INT DEFAULT NULL, root_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D754D550727ACA70 ON menu_item (parent_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D754D550CCD7E912 ON menu_item (menu_id)');
        $this->addSql('CREATE INDEX IDX_D754D55079066886 ON menu_item (root_id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9379066886 FOREIGN KEY (root_id) REFERENCES menu_item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_item ADD CONSTRAINT FK_D754D550727ACA70 FOREIGN KEY (parent_id) REFERENCES menu_item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_item ADD CONSTRAINT FK_D754D550CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_item ADD CONSTRAINT FK_D754D55079066886 FOREIGN KEY (root_id) REFERENCES menu_item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE menu_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE menu_item_id_seq CASCADE');
        $this->addSql('ALTER TABLE menu DROP CONSTRAINT FK_7D053A9379066886');
        $this->addSql('ALTER TABLE menu_item DROP CONSTRAINT FK_D754D550727ACA70');
        $this->addSql('ALTER TABLE menu_item DROP CONSTRAINT FK_D754D550CCD7E912');
        $this->addSql('ALTER TABLE menu_item DROP CONSTRAINT FK_D754D55079066886');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_item');
    }
}
