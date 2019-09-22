<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190922151146 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cabinet DROP FOREIGN KEY FK_4CED05B0309D1878');
        $this->addSql('DROP INDEX IDX_4CED05B0309D1878 ON cabinet');
        $this->addSql('ALTER TABLE cabinet DROP university_id');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB309D1878');
        $this->addSql('DROP INDEX IDX_5A3811FB309D1878 ON schedule');
        $this->addSql('ALTER TABLE schedule DROP university_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cabinet ADD university_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cabinet ADD CONSTRAINT FK_4CED05B0309D1878 FOREIGN KEY (university_id) REFERENCES university (id)');
        $this->addSql('CREATE INDEX IDX_4CED05B0309D1878 ON cabinet (university_id)');
        $this->addSql('ALTER TABLE schedule ADD university_id INT NOT NULL');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB309D1878 FOREIGN KEY (university_id) REFERENCES university (id)');
        $this->addSql('CREATE INDEX IDX_5A3811FB309D1878 ON schedule (university_id)');
    }
}
