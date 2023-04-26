<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426103249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD je_filme_mon_futur_metier VARCHAR(255) NOT NULL, ADD les_critiques_petillantes VARCHAR(255) NOT NULL, ADD parole_public VARCHAR(255) NOT NULL, ADD les_vitrines_des_cevennes VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP je_filme_mon_futur_metier, DROP les_critiques_petillantes, DROP parole_public, DROP les_vitrines_des_cevennes');
    }
}
