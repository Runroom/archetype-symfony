<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160915151650 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE static_page (id INT AUTO_INCREMENT NOT NULL, meta_information_id INT DEFAULT NULL, publish TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8FA4EF952051F018 (meta_information_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE static_page_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, locale VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B33A30C9989D9B62 (slug), INDEX IDX_B33A30C92C2AC5D3 (translatable_id), UNIQUE INDEX static_page_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE static_page ADD CONSTRAINT FK_8FA4EF952051F018 FOREIGN KEY (meta_information_id) REFERENCES entity_meta_information (id)');
        $this->addSql('ALTER TABLE static_page_translation ADD CONSTRAINT FK_B33A30C92C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES static_page (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE static_page_translation DROP FOREIGN KEY FK_B33A30C92C2AC5D3');
        $this->addSql('ALTER TABLE static_page DROP FOREIGN KEY FK_8FA4EF952051F018');
        $this->addSql('DROP TABLE static_page');
        $this->addSql('DROP TABLE static_page_translation');
    }
}
