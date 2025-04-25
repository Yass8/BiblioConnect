<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425123503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, fullname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE books (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, category_id INT DEFAULT NULL, themes_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_4A1B2A92F675F31B (author_id), INDEX IDX_4A1B2A9212469DE2 (category_id), INDEX IDX_4A1B2A9294F4A9D2 (themes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE languages (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, books_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, status VARCHAR(255) DEFAULT NULL, handed_over TINYINT(1) NOT NULL, INDEX IDX_4DA2397DD8AC20 (books_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stocks (id INT AUTO_INCREMENT NOT NULL, language_id INT DEFAULT NULL, quantity INT NOT NULL, quantity_reserved INT NOT NULL, quantity_available INT NOT NULL, INDEX IDX_56F7980582F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE themes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, reservations_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT '(DC2Type:json)', password VARCHAR(255) NOT NULL, INDEX IDX_8D93D649D9A7F869 (reservations_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE books ADD CONSTRAINT FK_4A1B2A92F675F31B FOREIGN KEY (author_id) REFERENCES author (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE books ADD CONSTRAINT FK_4A1B2A9212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE books ADD CONSTRAINT FK_4A1B2A9294F4A9D2 FOREIGN KEY (themes_id) REFERENCES themes (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservations ADD CONSTRAINT FK_4DA2397DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stocks ADD CONSTRAINT FK_56F7980582F1BAF4 FOREIGN KEY (language_id) REFERENCES languages (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649D9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservations (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE books DROP FOREIGN KEY FK_4A1B2A92F675F31B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE books DROP FOREIGN KEY FK_4A1B2A9212469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE books DROP FOREIGN KEY FK_4A1B2A9294F4A9D2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservations DROP FOREIGN KEY FK_4DA2397DD8AC20
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stocks DROP FOREIGN KEY FK_56F7980582F1BAF4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649D9A7F869
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE author
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE books
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE languages
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reservations
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stocks
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE themes
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `user`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
