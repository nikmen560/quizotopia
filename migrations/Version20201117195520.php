<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201117195520 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_position (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, quiz_id INT NOT NULL, result INT NOT NULL, spended_time VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', INDEX IDX_A6A100F5A76ED395 (user_id), INDEX IDX_A6A100F5853CD175 (quiz_id), PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE user_position ADD CONSTRAINT FK_A6A100F5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_position ADD CONSTRAINT FK_A6A100F5853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A254FAF8F53 FOREIGN KEY (question_id_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE quiz_question ADD CONSTRAINT FK_6033B00B853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE quiz_question ADD CONSTRAINT FK_6033B00B1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE quiz_user ADD CONSTRAINT FK_47622A12853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE quiz_user ADD CONSTRAINT FK_47622A12A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_user DROP FOREIGN KEY FK_47622A12A76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user_position DROP FOREIGN KEY FK_A6A100F5A76ED395');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_position');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A254FAF8F53');
        $this->addSql('ALTER TABLE quiz_question DROP FOREIGN KEY FK_6033B00B853CD175');
        $this->addSql('ALTER TABLE quiz_question DROP FOREIGN KEY FK_6033B00B1E27F6BF');
        $this->addSql('ALTER TABLE quiz_user DROP FOREIGN KEY FK_47622A12853CD175');
    }
}
