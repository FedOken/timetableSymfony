<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190721062626 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE shedule (id INT AUTO_INCREMENT NOT NULL, lesson_group_id INT DEFAULT NULL, lesson_type_id INT DEFAULT NULL, teacher_id INT DEFAULT NULL, building_id INT DEFAULT NULL, cabinet_id INT DEFAULT NULL, week_id INT DEFAULT NULL, lesson_name VARCHAR(255) DEFAULT NULL, INDEX IDX_E7771B51B613935E (lesson_group_id), INDEX IDX_E7771B513030DE34 (lesson_type_id), INDEX IDX_E7771B5141807E1D (teacher_id), INDEX IDX_E7771B514D2A7E12 (building_id), INDEX IDX_E7771B51D351EC (cabinet_id), INDEX IDX_E7771B51C86F3B2F (week_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shedule ADD CONSTRAINT FK_E7771B51B613935E FOREIGN KEY (lesson_group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE shedule ADD CONSTRAINT FK_E7771B513030DE34 FOREIGN KEY (lesson_type_id) REFERENCES lesson_type (id)');
        $this->addSql('ALTER TABLE shedule ADD CONSTRAINT FK_E7771B5141807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE shedule ADD CONSTRAINT FK_E7771B514D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('ALTER TABLE shedule ADD CONSTRAINT FK_E7771B51D351EC FOREIGN KEY (cabinet_id) REFERENCES cabinet (id)');
        $this->addSql('ALTER TABLE shedule ADD CONSTRAINT FK_E7771B51C86F3B2F FOREIGN KEY (week_id) REFERENCES week (id)');
        $this->addSql('ALTER TABLE teacher ADD position_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D5DD842E46 FOREIGN KEY (position_id) REFERENCES teacher_position (id)');
        $this->addSql('CREATE INDEX IDX_B0F6A6D5DD842E46 ON teacher (position_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE shedule');
        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D5DD842E46');
        $this->addSql('DROP INDEX IDX_B0F6A6D5DD842E46 ON teacher');
        $this->addSql('ALTER TABLE teacher DROP position_id');
    }
}
