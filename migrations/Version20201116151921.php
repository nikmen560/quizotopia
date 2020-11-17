<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201116151921 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz ADD created_at DATETIME NOT NULL, ADD status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE quiz_user ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE quiz_user ADD CONSTRAINT FK_47622A12A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_47622A12A76ED395 ON quiz_user (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz DROP created_at, DROP status');
        $this->addSql('ALTER TABLE quiz_user DROP FOREIGN KEY FK_47622A12A76ED395');
        $this->addSql('DROP INDEX IDX_47622A12A76ED395 ON quiz_user');
        $this->addSql('ALTER TABLE quiz_user DROP user_id');
    }
}
