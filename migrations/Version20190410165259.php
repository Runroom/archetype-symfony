<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190410165259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'RunroomRedirectionBundle migration';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE redirect (id INT AUTO_INCREMENT NOT NULL, source VARCHAR(500) NOT NULL, destination VARCHAR(500) NOT NULL, http_code INT NOT NULL, automatic TINYINT(1) NOT NULL, publish TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_C30C9E2B5F8A7F73 (source), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE redirect');
    }
}
