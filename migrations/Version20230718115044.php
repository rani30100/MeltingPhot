<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230718115044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video_image_video DROP FOREIGN KEY FK_4900EF2429C1004E');
        $this->addSql('ALTER TABLE video_image_video DROP FOREIGN KEY FK_4900EF24952717D1');
        $this->addSql('DROP TABLE video_image');
        $this->addSql('DROP TABLE video_image_video');
    }


}
