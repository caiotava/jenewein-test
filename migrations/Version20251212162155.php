<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251212162155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add course and user_course table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME)');
        $this->addSql('CREATE TABLE user_course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content_level VARCHAR(255) NOT NULL, user_id INTEGER DEFAULT NULL, course_id INTEGER NOT NULL, CONSTRAINT FK_user_course_user_id FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_user_course_course_id FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_73CC7484A76ED395 ON user_course (user_id)');
        $this->addSql('CREATE INDEX IDX_73CC7484591CC992 ON user_course (course_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE user_course');
    }
}
