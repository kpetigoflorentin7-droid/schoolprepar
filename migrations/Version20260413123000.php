<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260413123000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Augmente la taille des colonnes image a 1000 caracteres';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE filiere CHANGE image image VARCHAR(1000) DEFAULT NULL');
        $this->addSql('ALTER TABLE etablissement CHANGE image image VARCHAR(1000) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE filiere CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE etablissement CHANGE image image VARCHAR(255) DEFAULT NULL');
    }
}
