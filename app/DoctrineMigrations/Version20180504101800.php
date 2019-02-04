<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180504101800 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX IDX_C30C9E2B5F8A7F73B894CC41 ON redirect');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81BE2C742C42079 ON meta_information (route)');
        $this->addSql('CREATE INDEX IDX_B33A30C9989D9B62 ON static_page_translation (slug)');
        $this->addSql('CREATE INDEX IDX_8FA4EF95B894CC41 ON static_page (publish)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6BD307FA3A52145 ON message (message_key)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_B6BD307FA3A52145 ON message');
        $this->addSql('DROP INDEX UNIQ_81BE2C742C42079 ON meta_information');
        $this->addSql('CREATE INDEX IDX_C30C9E2B5F8A7F73B894CC41 ON redirect (source, publish)');
        $this->addSql('DROP INDEX IDX_8FA4EF95B894CC41 ON static_page');
        $this->addSql('DROP INDEX IDX_B33A30C9989D9B62 ON static_page_translation');
    }
}
