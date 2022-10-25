<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221025113802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent_user (id INT AUTO_INCREMENT NOT NULL, compte_id INT DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, kycverify TINYINT(1) DEFAULT NULL, balance DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_20086CAAF2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, flag VARCHAR(255) DEFAULT NULL, currency VARCHAR(255) DEFAULT NULL, rate DOUBLE PRECISION DEFAULT NULL, fixedcharged DOUBLE PRECISION DEFAULT NULL, percentcharge DOUBLE PRECISION DEFAULT NULL, status DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, compte_id INT DEFAULT NULL, datecreation DATETIME DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, kycverify TINYINT(1) DEFAULT NULL, emailverify TINYINT(1) DEFAULT NULL, phoneverify TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_81398E09F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deposit (id INT AUTO_INCREMENT NOT NULL, createdby_id INT DEFAULT NULL, charge DOUBLE PRECISION DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, payable DOUBLE PRECISION DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, rate DOUBLE PRECISION DEFAULT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_95DB9D39F0B5AF0B (createdby_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gateway_method (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, currency VARCHAR(255) NOT NULL, rate DOUBLE PRECISION DEFAULT NULL, minamount DOUBLE PRECISION DEFAULT NULL, maxamount DOUBLE PRECISION DEFAULT NULL, percentcharge DOUBLE PRECISION DEFAULT NULL, fixedcharge DOUBLE PRECISION DEFAULT NULL, instruction VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, createdby_id INT DEFAULT NULL, sourcefund_id INT DEFAULT NULL, sourcepurpose_id INT DEFAULT NULL, country_id INT DEFAULT NULL, countryfrom_id INT DEFAULT NULL, sender_id INT DEFAULT NULL, receiver_id INT DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, amountreceive DOUBLE PRECISION DEFAULT NULL, rate DOUBLE PRECISION DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_6D28840DF0B5AF0B (createdby_id), INDEX IDX_6D28840D6A6F4DEC (sourcefund_id), INDEX IDX_6D28840D5AC023E2 (sourcepurpose_id), INDEX IDX_6D28840DF92F3E70 (country_id), INDEX IDX_6D28840DC185D5FB (countryfrom_id), INDEX IDX_6D28840DF624B39D (sender_id), INDEX IDX_6D28840DCD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sender_receiver (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sourcefunds (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sourcepurpose (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, roles JSON DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, isactivate TINYINT(1) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, state VARCHAR(255) DEFAULT NULL, postal VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent_user ADD CONSTRAINT FK_20086CAAF2C56620 FOREIGN KEY (compte_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09F2C56620 FOREIGN KEY (compte_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE deposit ADD CONSTRAINT FK_95DB9D39F0B5AF0B FOREIGN KEY (createdby_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF0B5AF0B FOREIGN KEY (createdby_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D6A6F4DEC FOREIGN KEY (sourcefund_id) REFERENCES sourcefunds (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D5AC023E2 FOREIGN KEY (sourcepurpose_id) REFERENCES sourcepurpose (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DC185D5FB FOREIGN KEY (countryfrom_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF624B39D FOREIGN KEY (sender_id) REFERENCES sender_receiver (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES sender_receiver (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent_user DROP FOREIGN KEY FK_20086CAAF2C56620');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09F2C56620');
        $this->addSql('ALTER TABLE deposit DROP FOREIGN KEY FK_95DB9D39F0B5AF0B');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DF0B5AF0B');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D6A6F4DEC');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D5AC023E2');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DF92F3E70');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DC185D5FB');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DF624B39D');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DCD53EDB6');
        $this->addSql('DROP TABLE agent_user');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE deposit');
        $this->addSql('DROP TABLE gateway_method');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE sender_receiver');
        $this->addSql('DROP TABLE sourcefunds');
        $this->addSql('DROP TABLE sourcepurpose');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
