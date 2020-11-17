<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201116144433 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_position (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, quiz_id INT NOT NULL, spended_time DATETIME NOT NULL, result INT NOT NULL, INDEX IDX_A6A100F5A76ED395 (user_id), INDEX IDX_A6A100F5853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_position ADD CONSTRAINT FK_A6A100F5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_position ADD CONSTRAINT FK_A6A100F5853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_position');
    }
}
