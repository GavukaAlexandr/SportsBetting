<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170130134218 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE team_result (id INT AUTO_INCREMENT NOT NULL, team_game_result_id INT DEFAULT NULL, team_id INT DEFAULT NULL, gameResult INT NOT NULL, INDEX IDX_657186CA527CB6B6 (team_game_result_id), INDEX IDX_657186CA296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE team_result ADD CONSTRAINT FK_657186CA527CB6B6 FOREIGN KEY (team_game_result_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE team_result ADD CONSTRAINT FK_657186CA296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE team_result');
    }
}
