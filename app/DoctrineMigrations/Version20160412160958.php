<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160412160958 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE demo_translations (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_7DFB23712C2AC5D3 (translatable_id), UNIQUE INDEX demo_translations_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demo (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demo_translations ADD CONSTRAINT FK_7DFB23712C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES demo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demo ADD picture INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demo ADD CONSTRAINT FK_D642DFA016DB4F89 FOREIGN KEY (picture) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_D642DFA016DB4F89 ON demo (picture)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE demo_translations DROP FOREIGN KEY FK_7DFB23712C2AC5D3');
        $this->addSql('ALTER TABLE demo DROP FOREIGN KEY FK_D642DFA016DB4F89');
        $this->addSql('DROP TABLE demo_translations');
        $this->addSql('DROP TABLE demo');
    }
}
