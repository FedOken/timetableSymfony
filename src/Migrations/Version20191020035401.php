<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191020035401 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB4D2A7E12');
        $this->addSql('DROP INDEX IDX_5A3811FB4D2A7E12 ON schedule');
        $this->addSql('ALTER TABLE schedule DROP building_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE schedule ADD building_id INT NOT NULL');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB4D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('CREATE INDEX IDX_5A3811FB4D2A7E12 ON schedule (building_id)');
    }
}
