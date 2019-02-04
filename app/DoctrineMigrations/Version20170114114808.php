<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170114114808 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, picture_id INT DEFAULT NULL, position INT NOT NULL, publish TINYINT(1) NOT NULL, INDEX IDX_CBE5A33112469DE2 (category_id), INDEX IDX_CBE5A331EE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E69E0A13989D9B62 (slug), INDEX IDX_E69E0A132C2AC5D3 (translatable_id), UNIQUE INDEX book_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_3F207042C2AC5D3 (translatable_id), UNIQUE INDEX category_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331EE45BDBF FOREIGN KEY (picture_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE book_translation ADD CONSTRAINT FK_E69E0A132C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_translation ADD CONSTRAINT FK_3F207042C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE book_translation DROP FOREIGN KEY FK_E69E0A132C2AC5D3');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33112469DE2');
        $this->addSql('ALTER TABLE category_translation DROP FOREIGN KEY FK_3F207042C2AC5D3');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_translation');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_translation');
    }
}
