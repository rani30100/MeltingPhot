<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230905121056 extends AbstractMigration
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
        $this->addSql('DROP TABLE video_video_image');
        $this->addSql('DROP TABLE video_image_video');
        $this->addSql('ALTER TABLE image ADD page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FC4663E4 ON image (page_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE video_image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, image_path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE video_video_image (video_id INT NOT NULL, video_image_id INT NOT NULL, INDEX IDX_68DDBC5C29C1004E (video_id), INDEX IDX_68DDBC5C952717D1 (video_image_id), PRIMARY KEY(video_id, video_image_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE video_image_video (video_image_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_4900EF24952717D1 (video_image_id), INDEX IDX_4900EF2429C1004E (video_id), PRIMARY KEY(video_image_id, video_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE video_image_video ADD CONSTRAINT FK_4900EF2429C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_image_video ADD CONSTRAINT FK_4900EF24952717D1 FOREIGN KEY (video_image_id) REFERENCES video_image (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FC4663E4');
        $this->addSql('DROP INDEX IDX_C53D045FC4663E4 ON image');
        $this->addSql('ALTER TABLE image DROP page_id');
    }
}
