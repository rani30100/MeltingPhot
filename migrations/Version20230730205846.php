<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230730205846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_posts (page_id INT NOT NULL, posts_id INT NOT NULL, INDEX IDX_EEDC452CC4663E4 (page_id), INDEX IDX_EEDC452CD5E258C5 (posts_id), PRIMARY KEY(page_id, posts_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posts_page (posts_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_AE5A8F99D5E258C5 (posts_id), INDEX IDX_AE5A8F99C4663E4 (page_id), PRIMARY KEY(posts_id, page_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_posts ADD CONSTRAINT FK_EEDC452CC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_posts ADD CONSTRAINT FK_EEDC452CD5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts_page ADD CONSTRAINT FK_AE5A8F99D5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posts_page ADD CONSTRAINT FK_AE5A8F99C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page DROP posts');
        $this->addSql('ALTER TABLE posts DROP pages');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_posts DROP FOREIGN KEY FK_EEDC452CC4663E4');
        $this->addSql('ALTER TABLE page_posts DROP FOREIGN KEY FK_EEDC452CD5E258C5');
        $this->addSql('ALTER TABLE posts_page DROP FOREIGN KEY FK_AE5A8F99D5E258C5');
        $this->addSql('ALTER TABLE posts_page DROP FOREIGN KEY FK_AE5A8F99C4663E4');
        $this->addSql('DROP TABLE page_posts');
        $this->addSql('DROP TABLE posts_page');
        $this->addSql('ALTER TABLE posts ADD pages VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE page ADD posts VARCHAR(255) DEFAULT NULL');
    }
}
