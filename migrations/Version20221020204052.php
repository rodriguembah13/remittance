<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221020204052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sourcefunds (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sourcepurpose (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE country ADD rate DOUBLE PRECISION DEFAULT NULL, ADD fixedcharged DOUBLE PRECISION DEFAULT NULL, ADD percentcharge DOUBLE PRECISION DEFAULT NULL, ADD status DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD recepient_id INT DEFAULT NULL, ADD createdby_id INT DEFAULT NULL, ADD sourcefund_id INT DEFAULT NULL, ADD sourcepurpose_id INT DEFAULT NULL, ADD country_id INT DEFAULT NULL, ADD countryfrom_id INT DEFAULT NULL, ADD amountreceive DOUBLE PRECISION DEFAULT NULL, ADD rate DOUBLE PRECISION DEFAULT NULL, ADD reference VARCHAR(255) DEFAULT NULL, ADD status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF1B7C6C FOREIGN KEY (recepient_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF0B5AF0B FOREIGN KEY (createdby_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D6A6F4DEC FOREIGN KEY (sourcefund_id) REFERENCES sourcefunds (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D5AC023E2 FOREIGN KEY (sourcepurpose_id) REFERENCES sourcepurpose (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DC185D5FB FOREIGN KEY (countryfrom_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_6D28840DF1B7C6C ON payment (recepient_id)');
        $this->addSql('CREATE INDEX IDX_6D28840DF0B5AF0B ON payment (createdby_id)');
        $this->addSql('CREATE INDEX IDX_6D28840D6A6F4DEC ON payment (sourcefund_id)');
        $this->addSql('CREATE INDEX IDX_6D28840D5AC023E2 ON payment (sourcepurpose_id)');
        $this->addSql('CREATE INDEX IDX_6D28840DF92F3E70 ON payment (country_id)');
        $this->addSql('CREATE INDEX IDX_6D28840DC185D5FB ON payment (countryfrom_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D6A6F4DEC');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D5AC023E2');
        $this->addSql('DROP TABLE sourcefunds');
        $this->addSql('DROP TABLE sourcepurpose');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DF1B7C6C');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DF0B5AF0B');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DF92F3E70');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DC185D5FB');
        $this->addSql('DROP INDEX IDX_6D28840DF1B7C6C ON payment');
        $this->addSql('DROP INDEX IDX_6D28840DF0B5AF0B ON payment');
        $this->addSql('DROP INDEX IDX_6D28840D6A6F4DEC ON payment');
        $this->addSql('DROP INDEX IDX_6D28840D5AC023E2 ON payment');
        $this->addSql('DROP INDEX IDX_6D28840DF92F3E70 ON payment');
        $this->addSql('DROP INDEX IDX_6D28840DC185D5FB ON payment');
        $this->addSql('ALTER TABLE payment DROP recepient_id, DROP createdby_id, DROP sourcefund_id, DROP sourcepurpose_id, DROP country_id, DROP countryfrom_id, DROP amountreceive, DROP rate, DROP reference, DROP status');
        $this->addSql('ALTER TABLE country DROP rate, DROP fixedcharged, DROP percentcharge, DROP status');
    }
}
