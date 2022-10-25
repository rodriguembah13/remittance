<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221024133325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE deposit (id INT AUTO_INCREMENT NOT NULL, createdby_id INT DEFAULT NULL, charge DOUBLE PRECISION DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, payable DOUBLE PRECISION DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, rate DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_95DB9D39F0B5AF0B (createdby_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE deposit ADD CONSTRAINT FK_95DB9D39F0B5AF0B FOREIGN KEY (createdby_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payment ADD created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deposit DROP FOREIGN KEY FK_95DB9D39F0B5AF0B');
        $this->addSql('DROP TABLE deposit');
        $this->addSql('ALTER TABLE payment DROP created_at');
    }
}
