<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200531074627 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE reset_password_code reset_password_code VARCHAR(255) DEFAULT NULL, CHANGE check_email_code check_email_code VARCHAR(255) DEFAULT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE reset_password_code reset_password_code VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE check_email_code check_email_code VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE phone phone VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE first_name first_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE last_name last_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
