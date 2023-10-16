<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231013230350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ebook (id INT AUTO_INCREMENT NOT NULL, author VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, image_apercu VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', pdf VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, page_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, path VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_C53D045FA76ED395 (user_id), INDEX IDX_C53D045FC4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_page (image_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_E6305CBE3DA5256D (image_id), INDEX IDX_E6305CBEC4663E4 (page_id), PRIMARY KEY(image_id, page_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, send_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ready_to_prepare TINYINT(1) DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_user (newsletter_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_8516CE5222DB1917 (newsletter_id), INDEX IDX_8516CE52A76ED395 (user_id), PRIMARY KEY(newsletter_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_140AB620A76ED395 (user_id), INDEX slug (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_post (page_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_DD4E7057C4663E4 (page_id), INDEX IDX_DD4E70574B89032C (post_id), PRIMARY KEY(page_id, post_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, image_size INT DEFAULT NULL, description LONGTEXT NOT NULL, video_url VARCHAR(255) DEFAULT NULL, position VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_5A8A6C8DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_page (post_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_DD5FD12B4B89032C (post_id), INDEX IDX_DD5FD12BC4663E4 (page_id), PRIMARY KEY(post_id, page_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_image (post_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_522688B04B89032C (post_id), INDEX IDX_522688B03DA5256D (image_id), PRIMARY KEY(post_id, image_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_video (post_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_EBDC56C34B89032C (post_id), INDEX IDX_EBDC56C329C1004E (video_id), PRIMARY KEY(post_id, video_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', url VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_7CC7DA2CF47645AE (url), INDEX IDX_7CC7DA2CA76ED395 (user_id), INDEX IDX_7CC7DA2C12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE image_page ADD CONSTRAINT FK_E6305CBE3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image_page ADD CONSTRAINT FK_E6305CBEC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE newsletter_user ADD CONSTRAINT FK_8516CE5222DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE newsletter_user ADD CONSTRAINT FK_8516CE52A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE page_post ADD CONSTRAINT FK_DD4E7057C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_post ADD CONSTRAINT FK_DD4E70574B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post_page ADD CONSTRAINT FK_DD5FD12B4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_page ADD CONSTRAINT FK_DD5FD12BC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_image ADD CONSTRAINT FK_522688B04B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_image ADD CONSTRAINT FK_522688B03DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_video ADD CONSTRAINT FK_EBDC56C34B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_video ADD CONSTRAINT FK_EBDC56C329C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA76ED395');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FC4663E4');
        $this->addSql('ALTER TABLE image_page DROP FOREIGN KEY FK_E6305CBE3DA5256D');
        $this->addSql('ALTER TABLE image_page DROP FOREIGN KEY FK_E6305CBEC4663E4');
        $this->addSql('ALTER TABLE newsletter_user DROP FOREIGN KEY FK_8516CE5222DB1917');
        $this->addSql('ALTER TABLE newsletter_user DROP FOREIGN KEY FK_8516CE52A76ED395');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620A76ED395');
        $this->addSql('ALTER TABLE page_post DROP FOREIGN KEY FK_DD4E7057C4663E4');
        $this->addSql('ALTER TABLE page_post DROP FOREIGN KEY FK_DD4E70574B89032C');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        $this->addSql('ALTER TABLE post_page DROP FOREIGN KEY FK_DD5FD12B4B89032C');
        $this->addSql('ALTER TABLE post_page DROP FOREIGN KEY FK_DD5FD12BC4663E4');
        $this->addSql('ALTER TABLE post_image DROP FOREIGN KEY FK_522688B04B89032C');
        $this->addSql('ALTER TABLE post_image DROP FOREIGN KEY FK_522688B03DA5256D');
        $this->addSql('ALTER TABLE post_video DROP FOREIGN KEY FK_EBDC56C34B89032C');
        $this->addSql('ALTER TABLE post_video DROP FOREIGN KEY FK_EBDC56C329C1004E');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CA76ED395');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C12469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE ebook');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE image_page');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE newsletter_user');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_post');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_page');
        $this->addSql('DROP TABLE post_image');
        $this->addSql('DROP TABLE post_video');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
