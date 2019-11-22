<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191121140900 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE building DROP FOREIGN KEY FK_E16F61D4309D1878');
        $this->addSql('ALTER TABLE building CHANGE university_id university_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D4309D1878 FOREIGN KEY (university_id) REFERENCES university (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE cabinet DROP FOREIGN KEY FK_4CED05B04D2A7E12');
        $this->addSql('ALTER TABLE cabinet CHANGE building_id building_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cabinet ADD CONSTRAINT FK_4CED05B04D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9309D1878');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9309D1878 FOREIGN KEY (university_id) REFERENCES university (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE faculty DROP FOREIGN KEY FK_17966043309D1878');
        $this->addSql('ALTER TABLE faculty ADD CONSTRAINT FK_17966043309D1878 FOREIGN KEY (university_id) REFERENCES university (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D5309D1878');
        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D5DD842E46');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D5309D1878 FOREIGN KEY (university_id) REFERENCES university (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D5DD842E46 FOREIGN KEY (position_id) REFERENCES teacher_position (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE university_time DROP FOREIGN KEY FK_F273D5E6309D1878');
        $this->addSql('ALTER TABLE university_time ADD CONSTRAINT FK_F273D5E6309D1878 FOREIGN KEY (university_id) REFERENCES university (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE week DROP FOREIGN KEY FK_5B5A69C0309D1878');
        $this->addSql('ALTER TABLE week ADD CONSTRAINT FK_5B5A69C0309D1878 FOREIGN KEY (university_id) REFERENCES university (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE building DROP FOREIGN KEY FK_E16F61D4309D1878');
        $this->addSql('ALTER TABLE building CHANGE university_id university_id INT NOT NULL');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D4309D1878 FOREIGN KEY (university_id) REFERENCES university (id)');
        $this->addSql('ALTER TABLE cabinet DROP FOREIGN KEY FK_4CED05B04D2A7E12');
        $this->addSql('ALTER TABLE cabinet CHANGE building_id building_id INT NOT NULL');
        $this->addSql('ALTER TABLE cabinet ADD CONSTRAINT FK_4CED05B04D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9309D1878');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9309D1878 FOREIGN KEY (university_id) REFERENCES university (id)');
        $this->addSql('ALTER TABLE faculty DROP FOREIGN KEY FK_17966043309D1878');
        $this->addSql('ALTER TABLE faculty ADD CONSTRAINT FK_17966043309D1878 FOREIGN KEY (university_id) REFERENCES university (id)');
        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D5DD842E46');
        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D5309D1878');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D5DD842E46 FOREIGN KEY (position_id) REFERENCES teacher_position (id)');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D5309D1878 FOREIGN KEY (university_id) REFERENCES university (id)');
        $this->addSql('ALTER TABLE university_time DROP FOREIGN KEY FK_F273D5E6309D1878');
        $this->addSql('ALTER TABLE university_time ADD CONSTRAINT FK_F273D5E6309D1878 FOREIGN KEY (university_id) REFERENCES university (id)');
        $this->addSql('ALTER TABLE week DROP FOREIGN KEY FK_5B5A69C0309D1878');
        $this->addSql('ALTER TABLE week ADD CONSTRAINT FK_5B5A69C0309D1878 FOREIGN KEY (university_id) REFERENCES university (id)');
    }
}
