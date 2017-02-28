<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170202085554 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game ADD team_winner_id INT DEFAULT NULL, DROP teamWinner');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CEAF9CA5F FOREIGN KEY (team_winner_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_232B318CEAF9CA5F ON game (team_winner_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CEAF9CA5F');
        $this->addSql('DROP INDEX IDX_232B318CEAF9CA5F ON game');
        $this->addSql('ALTER TABLE game ADD teamWinner VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP team_winner_id');
    }
}
