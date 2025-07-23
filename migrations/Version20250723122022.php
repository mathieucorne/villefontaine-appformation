<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250723122022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE visibilite (id INT AUTO_INCREMENT NOT NULL, session_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_458F1F4F613FECDF (session_id), INDEX IDX_458F1F4FED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE visibilite ADD CONSTRAINT FK_458F1F4F613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE visibilite ADD CONSTRAINT FK_458F1F4FED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE session_service DROP FOREIGN KEY FK_F3451888613FECDF');
        $this->addSql('ALTER TABLE session_service DROP FOREIGN KEY FK_F3451888ED5CA9E6');
        $this->addSql('DROP TABLE session_service');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE session_service (id INT AUTO_INCREMENT NOT NULL, session_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_F3451888613FECDF (session_id), INDEX IDX_F3451888ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE session_service ADD CONSTRAINT FK_F3451888613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE session_service ADD CONSTRAINT FK_F3451888ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE visibilite DROP FOREIGN KEY FK_458F1F4F613FECDF');
        $this->addSql('ALTER TABLE visibilite DROP FOREIGN KEY FK_458F1F4FED5CA9E6');
        $this->addSql('DROP TABLE visibilite');
    }
}
