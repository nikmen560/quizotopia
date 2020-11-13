<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201113153527 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_question DROP INDEX UNIQ_6033B00B1E27F6BF, ADD INDEX IDX_6033B00B1E27F6BF (question_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_question DROP INDEX IDX_6033B00B1E27F6BF, ADD UNIQUE INDEX UNIQ_6033B00B1E27F6BF (question_id)');
    }
}
