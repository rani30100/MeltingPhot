<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230905013200 extends AbstractMigration
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
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F9D86650F');
        $this->addSql('DROP INDEX IDX_C53D045F9D86650F ON image');
        $this->addSql('ALTER TABLE image ADD post_id INT DEFAULT NULL, CHANGE path path VARCHAR(255) DEFAULT NULL, CHANGE user_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FA76ED395 ON image (user_id)');
        $this->addSql('CREATE INDEX IDX_C53D045F4B89032C ON image (post_id)');
        $this->addSql('ALTER TABLE posts ADD img_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, ADD path VARCHAR(255) DEFAULT NULL, ADD image_size INT DEFAULT NULL, ADD video_url VARCHAR(255) DEFAULT NULL, ADD video_file VARCHAR(255) DEFAULT NULL, ADD position VARCHAR(255) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP user_id_id');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAC06A9F55 FOREIGN KEY (img_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_885DBAFAA76ED395 ON posts (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_885DBAFAC06A9F55 ON posts (img_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE video_image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, image_path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE video_video_image (video_id INT NOT NULL, video_image_id INT NOT NULL, INDEX IDX_68DDBC5C29C1004E (video_id), INDEX IDX_68DDBC5C952717D1 (video_image_id), PRIMARY KEY(video_id, video_image_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE video_image_video (video_image_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_4900EF2429C1004E (video_id), INDEX IDX_4900EF24952717D1 (video_image_id), PRIMARY KEY(video_image_id, video_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE video_image_video ADD CONSTRAINT FK_4900EF2429C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_image_video ADD CONSTRAINT FK_4900EF24952717D1 FOREIGN KEY (video_image_id) REFERENCES video_image (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAA76ED395');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAC06A9F55');
        $this->addSql('DROP INDEX IDX_885DBAFAA76ED395 ON posts');
        $this->addSql('DROP INDEX UNIQ_885DBAFAC06A9F55 ON posts');
        $this->addSql('ALTER TABLE posts ADD user_id_id INT NOT NULL, DROP img_id, DROP user_id, DROP path, DROP image_size, DROP video_url, DROP video_file, DROP position, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA76ED395');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F4B89032C');
        $this->addSql('DROP INDEX IDX_C53D045FA76ED395 ON image');
        $this->addSql('DROP INDEX IDX_C53D045F4B89032C ON image');
        $this->addSql('ALTER TABLE image ADD user_id_id INT DEFAULT NULL, DROP user_id, DROP post_id, CHANGE path path VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C53D045F9D86650F ON image (user_id_id)');
    }
}
