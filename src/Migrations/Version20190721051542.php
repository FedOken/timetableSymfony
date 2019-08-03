<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190721051542 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE faculty ADD university_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty ADD CONSTRAINT FK_17966043309D1878 FOREIGN KEY (university_id) REFERENCES university (id)');
        $this->addSql('CREATE INDEX IDX_17966043309D1878 ON faculty (university_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE faculty DROP FOREIGN KEY FK_17966043309D1878');
        $this->addSql('DROP INDEX IDX_17966043309D1878 ON faculty');
        $this->addSql('ALTER TABLE faculty DROP university_id');
    }
}
