<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221023075521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sender_receiver (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DF1B7C6C');
        $this->addSql('DROP INDEX IDX_6D28840DF1B7C6C ON payment');
        $this->addSql('ALTER TABLE payment ADD receiver_id INT DEFAULT NULL, CHANGE recepient_id sender_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF624B39D FOREIGN KEY (sender_id) REFERENCES sender_receiver (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES sender_receiver (id)');
        $this->addSql('CREATE INDEX IDX_6D28840DF624B39D ON payment (sender_id)');
        $this->addSql('CREATE INDEX IDX_6D28840DCD53EDB6 ON payment (receiver_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DF624B39D');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DCD53EDB6');
        $this->addSql('DROP TABLE sender_receiver');
        $this->addSql('DROP INDEX IDX_6D28840DF624B39D ON payment');
        $this->addSql('DROP INDEX IDX_6D28840DCD53EDB6 ON payment');
        $this->addSql('ALTER TABLE payment ADD recepient_id INT DEFAULT NULL, DROP sender_id, DROP receiver_id');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF1B7C6C FOREIGN KEY (recepient_id) REFERENCES customer (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6D28840DF1B7C6C ON payment (recepient_id)');
    }
}
