<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221020142154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent_user DROP FOREIGN KEY FK_20086CAAF92F3E70');
        $this->addSql('DROP INDEX IDX_20086CAAF92F3E70 ON agent_user');
        $this->addSql('ALTER TABLE agent_user ADD country VARCHAR(255) DEFAULT NULL, ADD status VARCHAR(255) DEFAULT NULL, ADD kycverify TINYINT(1) DEFAULT NULL, ADD balance DOUBLE PRECISION DEFAULT NULL, DROP country_id');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09F92F3E70');
        $this->addSql('DROP INDEX IDX_81398E09F92F3E70 ON customer');
        $this->addSql('ALTER TABLE customer ADD country VARCHAR(255) DEFAULT NULL, ADD status VARCHAR(255) DEFAULT NULL, ADD kycverify TINYINT(1) DEFAULT NULL, ADD emailverify TINYINT(1) DEFAULT NULL, ADD phoneverify TINYINT(1) DEFAULT NULL, DROP country_id');
        $this->addSql('ALTER TABLE user ADD address VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD state VARCHAR(255) DEFAULT NULL, ADD postal VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent_user ADD country_id INT DEFAULT NULL, DROP country, DROP status, DROP kycverify, DROP balance');
        $this->addSql('ALTER TABLE agent_user ADD CONSTRAINT FK_20086CAAF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_20086CAAF92F3E70 ON agent_user (country_id)');
        $this->addSql('ALTER TABLE user DROP address, DROP city, DROP state, DROP postal');
        $this->addSql('ALTER TABLE customer ADD country_id INT DEFAULT NULL, DROP country, DROP status, DROP kycverify, DROP emailverify, DROP phoneverify');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_81398E09F92F3E70 ON customer (country_id)');
    }
}
