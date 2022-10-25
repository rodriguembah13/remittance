<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221025133623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deposit ADD method_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE deposit ADD CONSTRAINT FK_95DB9D3919883967 FOREIGN KEY (method_id) REFERENCES gateway_method (id)');
        $this->addSql('CREATE INDEX IDX_95DB9D3919883967 ON deposit (method_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deposit DROP FOREIGN KEY FK_95DB9D3919883967');
        $this->addSql('DROP INDEX IDX_95DB9D3919883967 ON deposit');
        $this->addSql('ALTER TABLE deposit DROP method_id');
    }
}
