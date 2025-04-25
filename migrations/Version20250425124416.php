<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425124416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE stocks ADD books_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stocks ADD CONSTRAINT FK_56F798057DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_56F798057DD8AC20 ON stocks (books_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE stocks DROP FOREIGN KEY FK_56F798057DD8AC20
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_56F798057DD8AC20 ON stocks
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stocks DROP books_id
        SQL);
    }
}
