<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231015203036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE posts_video');
        $this->addSql('DROP TABLE posts_page');
        $this->addSql('DROP TABLE posts_image');
        $this->addSql('DROP TABLE posts');
        $this->addSql('DROP TABLE page_posts');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE posts_video (posts_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_CEC0813DD5E258C5 (posts_id), INDEX IDX_CEC0813D29C1004E (video_id), PRIMARY KEY(posts_id, video_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE posts_page (posts_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_AE5A8F99D5E258C5 (posts_id), INDEX IDX_AE5A8F99C4663E4 (page_id), PRIMARY KEY(posts_id, page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE posts_image (posts_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_773A5F4ED5E258C5 (posts_id), INDEX IDX_773A5F4E3DA5256D (image_id), PRIMARY KEY(posts_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, image_size INT DEFAULT NULL, video_url VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, position VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_885DBAFAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE page_posts (page_id INT NOT NULL, posts_id INT NOT NULL, INDEX IDX_EEDC452CC4663E4 (page_id), INDEX IDX_EEDC452CD5E258C5 (posts_id), PRIMARY KEY(page_id, posts_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
    }
}
