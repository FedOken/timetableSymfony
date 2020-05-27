<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200514174537 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE building CHANGE university_id university_id INT DEFAULT NULL, CHANGE name_full name_full VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cabinet CHANGE building_id building_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course CHANGE university_id university_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty CHANGE university_id university_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE party CHANGE faculty_id faculty_id INT DEFAULT NULL, CHANGE course_id course_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE schedule CHANGE party_id party_id INT DEFAULT NULL, CHANGE lesson_type_id lesson_type_id INT DEFAULT NULL, CHANGE teacher_id teacher_id INT DEFAULT NULL, CHANGE cabinet_id cabinet_id INT DEFAULT NULL, CHANGE week_id week_id INT DEFAULT NULL, CHANGE day_id day_id INT DEFAULT NULL, CHANGE university_time_id university_time_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE teacher CHANGE position_id position_id INT DEFAULT NULL, CHANGE university_id university_id INT DEFAULT NULL, CHANGE name_full name_full VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE university_time CHANGE university_id university_id INT DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE role_label_id role_label_id INT DEFAULT NULL, CHANGE university_id university_id INT DEFAULT NULL, CHANGE faculty_id faculty_id INT DEFAULT NULL, CHANGE party_id party_id INT DEFAULT NULL, CHANGE teacher_id teacher_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE week CHANGE university_id university_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE building CHANGE university_id university_id INT DEFAULT NULL, CHANGE name_full name_full VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE cabinet CHANGE building_id building_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course CHANGE university_id university_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty CHANGE university_id university_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE party CHANGE faculty_id faculty_id INT DEFAULT NULL, CHANGE course_id course_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE schedule CHANGE party_id party_id INT DEFAULT NULL, CHANGE lesson_type_id lesson_type_id INT DEFAULT NULL, CHANGE teacher_id teacher_id INT DEFAULT NULL, CHANGE cabinet_id cabinet_id INT DEFAULT NULL, CHANGE week_id week_id INT DEFAULT NULL, CHANGE day_id day_id INT DEFAULT NULL, CHANGE university_time_id university_time_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE teacher CHANGE position_id position_id INT DEFAULT NULL, CHANGE university_id university_id INT DEFAULT NULL, CHANGE name_full name_full VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE university_time CHANGE university_id university_id INT DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE role_label_id role_label_id INT DEFAULT NULL, CHANGE university_id university_id INT DEFAULT NULL, CHANGE faculty_id faculty_id INT DEFAULT NULL, CHANGE party_id party_id INT DEFAULT NULL, CHANGE teacher_id teacher_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE week CHANGE university_id university_id INT DEFAULT NULL');
    }
}
