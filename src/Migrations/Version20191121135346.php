<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191121135346 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB213C1059');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB3030DE34');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB41807E1D');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB9C24126');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBC86F3B2F');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBD351EC');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBFE6D780C');
        $this->addSql('ALTER TABLE schedule CHANGE party_id party_id INT DEFAULT NULL, CHANGE lesson_type_id lesson_type_id INT DEFAULT NULL, CHANGE teacher_id teacher_id INT DEFAULT NULL, CHANGE cabinet_id cabinet_id INT DEFAULT NULL, CHANGE day_id day_id INT DEFAULT NULL, CHANGE university_time_id university_time_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB3030DE34 FOREIGN KEY (lesson_type_id) REFERENCES lesson_type (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB9C24126 FOREIGN KEY (day_id) REFERENCES day (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBC86F3B2F FOREIGN KEY (week_id) REFERENCES week (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBD351EC FOREIGN KEY (cabinet_id) REFERENCES cabinet (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBFE6D780C FOREIGN KEY (university_time_id) REFERENCES university_time (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB213C1059');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB3030DE34');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB41807E1D');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBD351EC');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBC86F3B2F');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB9C24126');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBFE6D780C');
        $this->addSql('ALTER TABLE schedule CHANGE party_id party_id INT NOT NULL, CHANGE lesson_type_id lesson_type_id INT NOT NULL, CHANGE teacher_id teacher_id INT NOT NULL, CHANGE cabinet_id cabinet_id INT NOT NULL, CHANGE day_id day_id INT NOT NULL, CHANGE university_time_id university_time_id INT NOT NULL');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB213C1059 FOREIGN KEY (party_id) REFERENCES party (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB3030DE34 FOREIGN KEY (lesson_type_id) REFERENCES lesson_type (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBD351EC FOREIGN KEY (cabinet_id) REFERENCES cabinet (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBC86F3B2F FOREIGN KEY (week_id) REFERENCES week (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB9C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBFE6D780C FOREIGN KEY (university_time_id) REFERENCES university_time (id)');
    }
}
