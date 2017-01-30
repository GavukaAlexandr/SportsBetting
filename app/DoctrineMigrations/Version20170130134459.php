<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170130134459 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team_result DROP FOREIGN KEY FK_657186CA527CB6B6');
        $this->addSql('DROP INDEX IDX_657186CA527CB6B6 ON team_result');
        $this->addSql('ALTER TABLE team_result CHANGE team_game_result_id game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team_result ADD CONSTRAINT FK_657186CAE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_657186CAE48FD905 ON team_result (game_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team_result DROP FOREIGN KEY FK_657186CAE48FD905');
        $this->addSql('DROP INDEX IDX_657186CAE48FD905 ON team_result');
        $this->addSql('ALTER TABLE team_result CHANGE game_id team_game_result_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team_result ADD CONSTRAINT FK_657186CA527CB6B6 FOREIGN KEY (team_game_result_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_657186CA527CB6B6 ON team_result (team_game_result_id)');
    }
}
