<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190721071040 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, party_id INT DEFAULT NULL, lesson_type_id INT DEFAULT NULL, teacher_id INT DEFAULT NULL, building_id INT DEFAULT NULL, cabinet_id INT DEFAULT NULL, week_id INT DEFAULT NULL, lesson_name VARCHAR(255) DEFAULT NULL, INDEX IDX_5A3811FB213C1059 (party_id), INDEX IDX_5A3811FB3030DE34 (lesson_type_id), INDEX IDX_5A3811FB41807E1D (teacher_id), INDEX IDX_5A3811FB4D2A7E12 (building_id), INDEX IDX_5A3811FBD351EC (cabinet_id), INDEX IDX_5A3811FBC86F3B2F (week_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB213C1059 FOREIGN KEY (party_id) REFERENCES party (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB3030DE34 FOREIGN KEY (lesson_type_id) REFERENCES lesson_type (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB4D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBD351EC FOREIGN KEY (cabinet_id) REFERENCES cabinet (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBC86F3B2F FOREIGN KEY (week_id) REFERENCES week (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE schedule');
    }
}
