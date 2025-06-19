<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250619130716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL, est_visible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE formation_competence (id INT AUTO_INCREMENT NOT NULL, formation_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_6C7CBB465200282E (formation_id), INDEX IDX_6C7CBB4615761DAB (competence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, session_id INT NOT NULL, date_inscription DATETIME NOT NULL, type_inscription SMALLINT DEFAULT NULL, INDEX IDX_AB55E24FFB88E14F (utilisateur_id), INDEX IDX_AB55E24F613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, batiment VARCHAR(255) DEFAULT NULL, nb_places_max SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, formation_id INT NOT NULL, salle_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, heure_debut DATETIME NOT NULL, heure_fin DATETIME NOT NULL, nb_participants_max SMALLINT NOT NULL, statut_session SMALLINT DEFAULT NULL, INDEX IDX_D044D5D45200282E (formation_id), INDEX IDX_D044D5D4DC304035 (salle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE session_service (id INT AUTO_INCREMENT NOT NULL, session_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_F3451888613FECDF (session_id), INDEX IDX_F3451888ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, type SMALLINT NOT NULL, INDEX IDX_1D1C63B3ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE utilisateur_competence (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_A66CAA69FB88E14F (utilisateur_id), INDEX IDX_A66CAA6915761DAB (competence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE formation_competence ADD CONSTRAINT FK_6C7CBB465200282E FOREIGN KEY (formation_id) REFERENCES formation (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE formation_competence ADD CONSTRAINT FK_6C7CBB4615761DAB FOREIGN KEY (competence_id) REFERENCES competence (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F613FECDF FOREIGN KEY (session_id) REFERENCES session (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE session ADD CONSTRAINT FK_D044D5D45200282E FOREIGN KEY (formation_id) REFERENCES formation (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE session ADD CONSTRAINT FK_D044D5D4DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE session_service ADD CONSTRAINT FK_F3451888613FECDF FOREIGN KEY (session_id) REFERENCES session (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE session_service ADD CONSTRAINT FK_F3451888ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur_competence ADD CONSTRAINT FK_A66CAA69FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur_competence ADD CONSTRAINT FK_A66CAA6915761DAB FOREIGN KEY (competence_id) REFERENCES competence (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE formation_competence DROP FOREIGN KEY FK_6C7CBB465200282E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE formation_competence DROP FOREIGN KEY FK_6C7CBB4615761DAB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FFB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F613FECDF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE session DROP FOREIGN KEY FK_D044D5D45200282E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4DC304035
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE session_service DROP FOREIGN KEY FK_F3451888613FECDF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE session_service DROP FOREIGN KEY FK_F3451888ED5CA9E6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3ED5CA9E6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur_competence DROP FOREIGN KEY FK_A66CAA69FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur_competence DROP FOREIGN KEY FK_A66CAA6915761DAB
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE competence
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE formation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE formation_competence
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE participation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE salle
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE service
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE session
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE session_service
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE utilisateur_competence
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
