<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250725070144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation_competence DROP FOREIGN KEY FK_6C7CBB465200282E');
        $this->addSql('ALTER TABLE formation_competence DROP FOREIGN KEY FK_6C7CBB4615761DAB');
        $this->addSql('ALTER TABLE utilisateur_competence DROP FOREIGN KEY FK_A66CAA6915761DAB');
        $this->addSql('ALTER TABLE utilisateur_competence DROP FOREIGN KEY FK_A66CAA69FB88E14F');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE formation_competence');
        $this->addSql('DROP TABLE utilisateur_competence');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE formation_competence (id INT AUTO_INCREMENT NOT NULL, formation_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_6C7CBB4615761DAB (competence_id), INDEX IDX_6C7CBB465200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE utilisateur_competence (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_A66CAA6915761DAB (competence_id), INDEX IDX_A66CAA69FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE formation_competence ADD CONSTRAINT FK_6C7CBB465200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE formation_competence ADD CONSTRAINT FK_6C7CBB4615761DAB FOREIGN KEY (competence_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE utilisateur_competence ADD CONSTRAINT FK_A66CAA6915761DAB FOREIGN KEY (competence_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE utilisateur_competence ADD CONSTRAINT FK_A66CAA69FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }
}
