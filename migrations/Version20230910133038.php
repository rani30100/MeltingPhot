<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230910133038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ebook_page DROP FOREIGN KEY FK_3FDA4EC4D80868CE');
        $this->addSql('DROP TABLE ebook_page');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ebook_page (id INT AUTO_INCREMENT NOT NULL, ebook_id_id INT NOT NULL, image_data LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_3FDA4EC4D80868CE (ebook_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ebook_page ADD CONSTRAINT FK_3FDA4EC4D80868CE FOREIGN KEY (ebook_id_id) REFERENCES ebook (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
