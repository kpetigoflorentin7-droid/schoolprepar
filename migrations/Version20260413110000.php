<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260413110000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout du champ image pour filiere et etablissement';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE etablissement ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE filiere ADD image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE etablissement DROP image');
        $this->addSql('ALTER TABLE filiere DROP image');
    }
}
