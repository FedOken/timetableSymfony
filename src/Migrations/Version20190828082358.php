<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190828082358 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_faculty');
        $this->addSql('ALTER TABLE user ADD access_code VARCHAR(255) NOT NULL, ADD enable TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_faculty (user_id INT NOT NULL, faculty_id INT NOT NULL, INDEX IDX_4F9B7E49A76ED395 (user_id), INDEX IDX_4F9B7E49680CAB68 (faculty_id), PRIMARY KEY(user_id, faculty_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_faculty ADD CONSTRAINT FK_4F9B7E49680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_faculty ADD CONSTRAINT FK_4F9B7E49A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP access_code, DROP enable');
    }
}
