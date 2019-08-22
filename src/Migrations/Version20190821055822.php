<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190821055822 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE schedule CHANGE party_id party_id INT NOT NULL, CHANGE lesson_type_id lesson_type_id INT NOT NULL, CHANGE teacher_id teacher_id INT NOT NULL, CHANGE building_id building_id INT NOT NULL, CHANGE week_id week_id INT NOT NULL, CHANGE university_id university_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE schedule CHANGE party_id party_id INT DEFAULT NULL, CHANGE lesson_type_id lesson_type_id INT DEFAULT NULL, CHANGE teacher_id teacher_id INT DEFAULT NULL, CHANGE building_id building_id INT DEFAULT NULL, CHANGE week_id week_id INT DEFAULT NULL, CHANGE university_id university_id INT DEFAULT NULL');
    }
}
