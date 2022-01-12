<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220111163050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial migration';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf(!$this->connection->getDatabasePlatform() instanceof PostgreSQLPlatform, 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE SEQUENCE basic_page_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE basic_page_translation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE book_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE book_translation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_translation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cookies_page_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cookies_page_translation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE entity_meta_information_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE entity_meta_information_translation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE media__gallery_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE media__gallery_media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE media__media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE meta_information_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE meta_information_translation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE redirect_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reset_password_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE translation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE translation_translation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE basic_page (id INT NOT NULL, meta_information_id INT DEFAULT NULL, location VARCHAR(255) NOT NULL, publish BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_401CFA4B2051F018 ON basic_page (meta_information_id)');
        $this->addSql('CREATE INDEX IDX_401CFA4BB894CC41 ON basic_page (publish)');
        $this->addSql('CREATE TABLE basic_page_translation (id INT NOT NULL, translatable_id INT DEFAULT NULL, locale VARCHAR(5) NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, content TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2349B9E62C2AC5D3 ON basic_page_translation (translatable_id)');
        $this->addSql('CREATE INDEX IDX_2349B9E6989D9B62 ON basic_page_translation (slug)');
        $this->addSql('CREATE UNIQUE INDEX basic_page_translation_unique_translation ON basic_page_translation (translatable_id, locale)');
        $this->addSql('CREATE TABLE book (id INT NOT NULL, category_id INT DEFAULT NULL, picture_id INT DEFAULT NULL, publish BOOLEAN NOT NULL, position INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CBE5A33112469DE2 ON book (category_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331EE45BDBF ON book (picture_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331B894CC41 ON book (publish)');
        $this->addSql('CREATE TABLE book_translation (id INT NOT NULL, translatable_id INT DEFAULT NULL, locale VARCHAR(5) NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E69E0A132C2AC5D3 ON book_translation (translatable_id)');
        $this->addSql('CREATE INDEX IDX_E69E0A13989D9B62 ON book_translation (slug)');
        $this->addSql('CREATE UNIQUE INDEX book_translation_unique_translation ON book_translation (translatable_id, locale)');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE category_translation (id INT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3F207042C2AC5D3 ON category_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX category_translation_unique_translation ON category_translation (translatable_id, locale)');
        $this->addSql('CREATE TABLE contact (id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, subject INT NOT NULL, type INT NOT NULL, preferences TEXT NOT NULL, comment TEXT NOT NULL, newsletter BOOLEAN NOT NULL, privacy_policy BOOLEAN NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN contact.preferences IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE cookies_page (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cookies_page_translation (id INT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content TEXT DEFAULT NULL, locale VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_93DF3F4E2C2AC5D3 ON cookies_page_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX cookies_page_translation_unique_translation ON cookies_page_translation (translatable_id, locale)');
        $this->addSql('CREATE TABLE entity_meta_information (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE entity_meta_information_translation (id INT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, locale VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F65116A92C2AC5D3 ON entity_meta_information_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX entity_meta_information_translation_unique_translation ON entity_meta_information_translation (translatable_id, locale)');
        $this->addSql('CREATE TABLE media__gallery (id INT NOT NULL, name VARCHAR(255) NOT NULL, context VARCHAR(64) NOT NULL, default_format VARCHAR(255) NOT NULL, enabled BOOLEAN NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE media__gallery_media (id INT NOT NULL, gallery_id INT DEFAULT NULL, media_id INT DEFAULT NULL, position INT NOT NULL, enabled BOOLEAN NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_80D4C5414E7AF8F ON media__gallery_media (gallery_id)');
        $this->addSql('CREATE INDEX IDX_80D4C541EA9FDD75 ON media__gallery_media (media_id)');
        $this->addSql('CREATE TABLE media__media (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, enabled BOOLEAN NOT NULL, provider_name VARCHAR(255) NOT NULL, provider_status INT NOT NULL, provider_reference VARCHAR(255) NOT NULL, provider_metadata JSON DEFAULT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, length NUMERIC(10, 0) DEFAULT NULL, content_type VARCHAR(255) DEFAULT NULL, content_size INT DEFAULT NULL, copyright VARCHAR(255) DEFAULT NULL, author_name VARCHAR(255) DEFAULT NULL, context VARCHAR(64) DEFAULT NULL, cdn_is_flushable BOOLEAN NOT NULL, cdn_flush_identifier VARCHAR(64) DEFAULT NULL, cdn_flush_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, cdn_status INT DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE meta_information (id INT NOT NULL, image_id INT DEFAULT NULL, route VARCHAR(255) NOT NULL, route_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81BE2C742C42079 ON meta_information (route)');
        $this->addSql('CREATE INDEX IDX_81BE2C743DA5256D ON meta_information (image_id)');
        $this->addSql('CREATE TABLE meta_information_translation (id INT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, locale VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A00FFF8C2C2AC5D3 ON meta_information_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX meta_information_translation_unique_translation ON meta_information_translation (translatable_id, locale)');
        $this->addSql('CREATE TABLE redirect (id INT NOT NULL, source VARCHAR(500) NOT NULL, destination VARCHAR(500) NOT NULL, http_code INT NOT NULL, automatic BOOLEAN NOT NULL, publish BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C30C9E2B5F8A7F73 ON redirect (source)');
        $this->addSql('CREATE TABLE reset_password_request (id INT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('COMMENT ON COLUMN reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE translation (id INT NOT NULL, translation_key VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B469456FAADCBD56 ON translation (translation_key)');
        $this->addSql('CREATE TABLE translation_translation (id INT NOT NULL, translatable_id INT DEFAULT NULL, value TEXT DEFAULT NULL, locale VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2F770F6E2C2AC5D3 ON translation_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX translation_translation_unique_translation ON translation_translation (translatable_id, locale)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, enabled BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE basic_page ADD CONSTRAINT FK_401CFA4B2051F018 FOREIGN KEY (meta_information_id) REFERENCES entity_meta_information (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE basic_page_translation ADD CONSTRAINT FK_2349B9E62C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES basic_page (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331EE45BDBF FOREIGN KEY (picture_id) REFERENCES media__media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book_translation ADD CONSTRAINT FK_E69E0A132C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_translation ADD CONSTRAINT FK_3F207042C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cookies_page_translation ADD CONSTRAINT FK_93DF3F4E2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES cookies_page (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity_meta_information_translation ADD CONSTRAINT FK_F65116A92C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES entity_meta_information (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C5414E7AF8F FOREIGN KEY (gallery_id) REFERENCES media__gallery (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media__gallery_media ADD CONSTRAINT FK_80D4C541EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE meta_information ADD CONSTRAINT FK_81BE2C743DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE meta_information_translation ADD CONSTRAINT FK_A00FFF8C2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES meta_information (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE translation_translation ADD CONSTRAINT FK_2F770F6E2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES translation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf(!$this->connection->getDatabasePlatform() instanceof PostgreSQLPlatform, 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE basic_page_translation DROP CONSTRAINT FK_2349B9E62C2AC5D3');
        $this->addSql('ALTER TABLE book_translation DROP CONSTRAINT FK_E69E0A132C2AC5D3');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A33112469DE2');
        $this->addSql('ALTER TABLE category_translation DROP CONSTRAINT FK_3F207042C2AC5D3');
        $this->addSql('ALTER TABLE cookies_page_translation DROP CONSTRAINT FK_93DF3F4E2C2AC5D3');
        $this->addSql('ALTER TABLE basic_page DROP CONSTRAINT FK_401CFA4B2051F018');
        $this->addSql('ALTER TABLE entity_meta_information_translation DROP CONSTRAINT FK_F65116A92C2AC5D3');
        $this->addSql('ALTER TABLE media__gallery_media DROP CONSTRAINT FK_80D4C5414E7AF8F');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A331EE45BDBF');
        $this->addSql('ALTER TABLE media__gallery_media DROP CONSTRAINT FK_80D4C541EA9FDD75');
        $this->addSql('ALTER TABLE meta_information DROP CONSTRAINT FK_81BE2C743DA5256D');
        $this->addSql('ALTER TABLE meta_information_translation DROP CONSTRAINT FK_A00FFF8C2C2AC5D3');
        $this->addSql('ALTER TABLE translation_translation DROP CONSTRAINT FK_2F770F6E2C2AC5D3');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748AA76ED395');
        $this->addSql('DROP SEQUENCE basic_page_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE basic_page_translation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE book_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE book_translation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_translation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contact_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cookies_page_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cookies_page_translation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE entity_meta_information_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE entity_meta_information_translation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE media__gallery_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE media__gallery_media_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE media__media_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE meta_information_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE meta_information_translation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE redirect_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reset_password_request_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE translation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE translation_translation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('DROP TABLE basic_page');
        $this->addSql('DROP TABLE basic_page_translation');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_translation');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_translation');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE cookies_page');
        $this->addSql('DROP TABLE cookies_page_translation');
        $this->addSql('DROP TABLE entity_meta_information');
        $this->addSql('DROP TABLE entity_meta_information_translation');
        $this->addSql('DROP TABLE media__gallery');
        $this->addSql('DROP TABLE media__gallery_media');
        $this->addSql('DROP TABLE media__media');
        $this->addSql('DROP TABLE meta_information');
        $this->addSql('DROP TABLE meta_information_translation');
        $this->addSql('DROP TABLE redirect');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE translation');
        $this->addSql('DROP TABLE translation_translation');
        $this->addSql('DROP TABLE "user"');
    }
}
