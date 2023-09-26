<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230926143721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_post (page_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_DD4E7057C4663E4 (page_id), INDEX IDX_DD4E70574B89032C (post_id), PRIMARY KEY(page_id, post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, image_size INT DEFAULT NULL, description LONGTEXT NOT NULL, video_url VARCHAR(255) DEFAULT NULL, position VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_5A8A6C8DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_page (post_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_DD5FD12B4B89032C (post_id), INDEX IDX_DD5FD12BC4663E4 (page_id), PRIMARY KEY(post_id, page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_image (post_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_522688B04B89032C (post_id), INDEX IDX_522688B03DA5256D (image_id), PRIMARY KEY(post_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_video (post_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_EBDC56C34B89032C (post_id), INDEX IDX_EBDC56C329C1004E (video_id), PRIMARY KEY(post_id, video_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_post ADD CONSTRAINT FK_DD4E7057C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_post ADD CONSTRAINT FK_DD4E70574B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post_page ADD CONSTRAINT FK_DD5FD12B4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_page ADD CONSTRAINT FK_DD5FD12BC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_image ADD CONSTRAINT FK_522688B04B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_image ADD CONSTRAINT FK_522688B03DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_video ADD CONSTRAINT FK_EBDC56C34B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_video ADD CONSTRAINT FK_EBDC56C329C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_posts DROP FOREIGN KEY FK_EEDC452CD5E258C5');
        $this->addSql('ALTER TABLE page_posts DROP FOREIGN KEY FK_EEDC452CC4663E4');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAA76ED395');
        $this->addSql('ALTER TABLE posts_image DROP FOREIGN KEY FK_773A5F4E3DA5256D');
        $this->addSql('ALTER TABLE posts_image DROP FOREIGN KEY FK_773A5F4ED5E258C5');
        $this->addSql('ALTER TABLE posts_page DROP FOREIGN KEY FK_AE5A8F99D5E258C5');
        $this->addSql('ALTER TABLE posts_page DROP FOREIGN KEY FK_AE5A8F99C4663E4');
        $this->addSql('ALTER TABLE posts_video DROP FOREIGN KEY FK_CEC0813DD5E258C5');
        $this->addSql('ALTER TABLE posts_video DROP FOREIGN KEY FK_CEC0813D29C1004E');
        $this->addSql('DROP TABLE page_posts');
        $this->addSql('DROP TABLE posts');
        $this->addSql('DROP TABLE posts_image');
        $this->addSql('DROP TABLE posts_page');
        $this->addSql('DROP TABLE posts_video');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_posts (page_id INT NOT NULL, posts_id INT NOT NULL, INDEX IDX_EEDC452CC4663E4 (page_id), INDEX IDX_EEDC452CD5E258C5 (posts_id), PRIMARY KEY(page_id, posts_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, image_size INT DEFAULT NULL, video_url VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, position VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_885DBAFAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE posts_image (posts_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_773A5F4ED5E258C5 (posts_id), INDEX IDX_773A5F4E3DA5256D (image_id), PRIMARY KEY(posts_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE posts_page (posts_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_AE5A8F99D5E258C5 (posts_id), INDEX IDX_AE5A8F99C4663E4 (page_id), PRIMARY KEY(posts_id, page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE posts_video (posts_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_CEC0813DD5E258C5 (posts_id), INDEX IDX_CEC0813D29C1004E (video_id), PRIMARY KEY(posts_id, video_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE page_posts ADD CONSTRAINT FK_EEDC452CD5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_posts ADD CONSTRAINT FK_EEDC452CC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE posts_image ADD CONSTRAINT FK_773A5F4E3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts_image ADD CONSTRAINT FK_773A5F4ED5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts_page ADD CONSTRAINT FK_AE5A8F99D5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts_page ADD CONSTRAINT FK_AE5A8F99C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts_video ADD CONSTRAINT FK_CEC0813DD5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts_video ADD CONSTRAINT FK_CEC0813D29C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_post DROP FOREIGN KEY FK_DD4E7057C4663E4');
        $this->addSql('ALTER TABLE page_post DROP FOREIGN KEY FK_DD4E70574B89032C');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        $this->addSql('ALTER TABLE post_page DROP FOREIGN KEY FK_DD5FD12B4B89032C');
        $this->addSql('ALTER TABLE post_page DROP FOREIGN KEY FK_DD5FD12BC4663E4');
        $this->addSql('ALTER TABLE post_image DROP FOREIGN KEY FK_522688B04B89032C');
        $this->addSql('ALTER TABLE post_image DROP FOREIGN KEY FK_522688B03DA5256D');
        $this->addSql('ALTER TABLE post_video DROP FOREIGN KEY FK_EBDC56C34B89032C');
        $this->addSql('ALTER TABLE post_video DROP FOREIGN KEY FK_EBDC56C329C1004E');
        $this->addSql('DROP TABLE page_post');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_page');
        $this->addSql('DROP TABLE post_image');
        $this->addSql('DROP TABLE post_video');
    }
}
