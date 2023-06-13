<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613232113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video ADD video_image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE video_video_image DROP FOREIGN KEY FK_68DDBC5C29C1004E');
        $this->addSql('ALTER TABLE video_video_image ADD CONSTRAINT FK_68DDBC5C29C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video DROP video_image');
        $this->addSql('ALTER TABLE video_video_image DROP FOREIGN KEY FK_68DDBC5C29C1004E');
        $this->addSql('ALTER TABLE video_video_image ADD CONSTRAINT FK_68DDBC5C29C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
