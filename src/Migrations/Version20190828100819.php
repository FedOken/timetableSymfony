<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190828100819 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD university_id INT DEFAULT NULL, ADD faculty_id INT DEFAULT NULL, ADD party_id INT DEFAULT NULL, ADD teacher_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649309D1878 FOREIGN KEY (university_id) REFERENCES university (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649213C1059 FOREIGN KEY (party_id) REFERENCES party (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64941807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649309D1878 ON user (university_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649680CAB68 ON user (faculty_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649213C1059 ON user (party_id)');
        $this->addSql('CREATE INDEX IDX_8D93D64941807E1D ON user (teacher_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649309D1878');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649680CAB68');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649213C1059');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64941807E1D');
        $this->addSql('DROP INDEX IDX_8D93D649309D1878 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649680CAB68 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649213C1059 ON user');
        $this->addSql('DROP INDEX IDX_8D93D64941807E1D ON user');
        $this->addSql('ALTER TABLE user DROP university_id, DROP faculty_id, DROP party_id, DROP teacher_id');
    }
}
