<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230910170158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ebook_image (id INT AUTO_INCREMENT NOT NULL, ebook_id INT NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', name VARCHAR(255) NOT NULL, size INT NOT NULL, INDEX IDX_6271F2C676E71D49 (ebook_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ebook_image ADD CONSTRAINT FK_6271F2C676E71D49 FOREIGN KEY (ebook_id) REFERENCES ebook (id)');
        $this->addSql('ALTER TABLE ebook DROP updated_at, DROP images');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ebook_image DROP FOREIGN KEY FK_6271F2C676E71D49');
        $this->addSql('DROP TABLE ebook_image');
        $this->addSql('ALTER TABLE ebook ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD images JSON DEFAULT NULL');
    }
}
