<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190721065750 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shedule DROP FOREIGN KEY FK_E7771B51B613935E');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP INDEX IDX_E7771B51B613935E ON shedule');
        $this->addSql('ALTER TABLE shedule DROP lesson_group_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, faculty_id INT DEFAULT NULL, course_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, enable TINYINT(1) NOT NULL, INDEX IDX_6DC044C5591CC992 (course_id), INDEX IDX_6DC044C5680CAB68 (faculty_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C5591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C5680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id)');
        $this->addSql('ALTER TABLE shedule ADD lesson_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shedule ADD CONSTRAINT FK_E7771B51B613935E FOREIGN KEY (lesson_group_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_E7771B51B613935E ON shedule (lesson_group_id)');
    }
}
