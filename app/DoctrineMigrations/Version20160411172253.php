<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160411172253 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("INSERT INTO `fos_user_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `created_at`, `updated_at`, `date_of_birth`, `firstname`, `lastname`, `website`, `biography`, `gender`, `locale`, `timezone`, `phone`, `facebook_uid`, `facebook_name`, `facebook_data`, `twitter_uid`, `twitter_name`, `twitter_data`, `gplus_uid`, `gplus_name`, `gplus_data`, `token`, `two_step_code`) VALUES (1, 'admin', 'admin', 'runroom@runroom.com', 'runroom@runroom.com', 1, 'edqydhlforw4kc4wg4gg4skks4gcsck', 'rUhrE6Fwm9r94oH+5+NW+aJrRp9cT65dwGUYt8z7XCtiNIEFiHT52145AuDSwg6CvRGuLbT5yzAm6ezVQVRTsQ==', NULL, 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', 0, NULL, '2016-04-11 17:21:21', '2016-04-11 17:21:21', NULL, NULL, NULL, NULL, NULL, 'u', NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, 'null', NULL, NULL, 'null', NULL, NULL);");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DELETE FROM fos_user_user WHERE id='1'");
    }
}
