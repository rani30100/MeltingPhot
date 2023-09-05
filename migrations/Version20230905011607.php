<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230905011607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_posts DROP FOREIGN KEY FK_EEDC452CC4663E4');
        $this->addSql('ALTER TABLE page_posts DROP FOREIGN KEY FK_EEDC452CD5E258C5');
        $this->addSql('ALTER TABLE posts_page DROP FOREIGN KEY FK_AE5A8F99C4663E4');
        $this->addSql('ALTER TABLE posts_page DROP FOREIGN KEY FK_AE5A8F99D5E258C5');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_posts');
        $this->addSql('DROP TABLE posts_page');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F4B89032C');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA76ED395');
        $this->addSql('DROP INDEX IDX_C53D045FA76ED395 ON image');
        $this->addSql('DROP INDEX IDX_C53D045F4B89032C ON image');
        $this->addSql('ALTER TABLE image ADD user_id_id INT DEFAULT NULL, DROP user_id, DROP post_id, CHANGE path path VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F9D86650F ON image (user_id_id)');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA55EEBBF7');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAA76ED395');
        $this->addSql('DROP INDEX UNIQ_885DBAFAC06A9F55 ON posts');
        $this->addSql('DROP INDEX IDX_885DBAFAA76ED395 ON posts');
        $this->addSql('ALTER TABLE posts ADD user_id_id INT NOT NULL, DROP user_id, DROP img_id, DROP video_url, DROP video_file, DROP position, DROP updated_at, DROP created_at, DROP path, DROP image_size');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_885DBAFA9D86650F ON posts (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, INDEX slug (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE page_posts (page_id INT NOT NULL, posts_id INT NOT NULL, INDEX IDX_EEDC452CC4663E4 (page_id), INDEX IDX_EEDC452CD5E258C5 (posts_id), PRIMARY KEY(page_id, posts_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE posts_page (posts_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_AE5A8F99D5E258C5 (posts_id), INDEX IDX_AE5A8F99C4663E4 (page_id), PRIMARY KEY(posts_id, page_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, hashed_token VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE page_posts ADD CONSTRAINT FK_EEDC452CC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_posts ADD CONSTRAINT FK_EEDC452CD5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts_page ADD CONSTRAINT FK_AE5A8F99C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts_page ADD CONSTRAINT FK_AE5A8F99D5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA9D86650F');
        $this->addSql('DROP INDEX IDX_885DBAFA9D86650F ON posts');
        $this->addSql('ALTER TABLE posts ADD user_id INT DEFAULT NULL, ADD img_id INT DEFAULT NULL, ADD video_url VARCHAR(255) DEFAULT NULL, ADD video_file VARCHAR(255) DEFAULT NULL, ADD position VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD path VARCHAR(255) DEFAULT NULL, ADD image_size INT DEFAULT NULL, DROP user_id_id');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA55EEBBF7 FOREIGN KEY (img_id) REFERENCES image (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_885DBAFAC06A9F55 ON posts (img_id)');
        $this->addSql('CREATE INDEX IDX_885DBAFAA76ED395 ON posts (user_id)');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F9D86650F');
        $this->addSql('DROP INDEX IDX_C53D045F9D86650F ON image');
        $this->addSql('ALTER TABLE image ADD post_id INT DEFAULT NULL, CHANGE path path VARCHAR(255) DEFAULT NULL, CHANGE user_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4B89032C FOREIGN KEY (post_id) REFERENCES posts (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C53D045FA76ED395 ON image (user_id)');
        $this->addSql('CREATE INDEX IDX_C53D045F4B89032C ON image (post_id)');
    }
}
