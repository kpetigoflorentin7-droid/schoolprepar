<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260413092230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        if ($schema->hasTable('debouche')) {
            return;
        }

        $this->addSql('CREATE TABLE debouche (id INT AUTO_INCREMENT NOT NULL, metier VARCHAR(150) NOT NULL, secteur VARCHAR(100) DEFAULT NULL, salaire_moyen INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, filiere_id INT NOT NULL, INDEX IDX_30DF0D08180AA129 (filiere_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE etablissement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(150) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, ville VARCHAR(100) DEFAULT NULL, email VARCHAR(100) DEFAULT NULL, telephone VARCHAR(20) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE etablissement_filiere (etablissement_id INT NOT NULL, filiere_id INT NOT NULL, INDEX IDX_2AC1425DFF631228 (etablissement_id), INDEX IDX_2AC1425D180AA129 (filiere_id), PRIMARY KEY (etablissement_id, filiere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(200) NOT NULL, description LONGTEXT DEFAULT NULL, date DATETIME NOT NULL, lieu VARCHAR(255) DEFAULT NULL, type VARCHAR(50) DEFAULT NULL, places_max INT DEFAULT NULL, etablissement_id INT NOT NULL, INDEX IDX_B26681EFF631228 (etablissement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE filiere (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(150) NOT NULL, domaine VARCHAR(100) DEFAULT NULL, description LONGTEXT DEFAULT NULL, conditions_admission VARCHAR(255) DEFAULT NULL, duree INT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, date_heure DATETIME NOT NULL, statut VARCHAR(20) NOT NULL, motif LONGTEXT DEFAULT NULL, mode VARCHAR(50) DEFAULT NULL, eleve_id INT NOT NULL, conseiller_id INT NOT NULL, INDEX IDX_65E8AA0AA6CC7B2 (eleve_id), INDEX IDX_65E8AA0A1AC39A0D (conseiller_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, telephone VARCHAR(30) DEFAULT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE debouche ADD CONSTRAINT FK_30DF0D08180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('ALTER TABLE etablissement_filiere ADD CONSTRAINT FK_2AC1425DFF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etablissement_filiere ADD CONSTRAINT FK_2AC1425D180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EFF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AA6CC7B2 FOREIGN KEY (eleve_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A1AC39A0D FOREIGN KEY (conseiller_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE debouche DROP FOREIGN KEY FK_30DF0D08180AA129');
        $this->addSql('ALTER TABLE etablissement_filiere DROP FOREIGN KEY FK_2AC1425DFF631228');
        $this->addSql('ALTER TABLE etablissement_filiere DROP FOREIGN KEY FK_2AC1425D180AA129');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EFF631228');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AA6CC7B2');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A1AC39A0D');
        $this->addSql('DROP TABLE debouche');
        $this->addSql('DROP TABLE etablissement');
        $this->addSql('DROP TABLE etablissement_filiere');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE filiere');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE utilisateur');
    }
}
