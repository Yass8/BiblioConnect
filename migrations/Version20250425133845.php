<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425133845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE reservations ADD user_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_4DA239A76ED395 ON reservations (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D9A7F869
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_8D93D649D9A7F869 ON user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP reservations_id
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_4DA239A76ED395 ON reservations
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservations DROP user_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` ADD reservations_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649D9A7F869 FOREIGN KEY (reservations_id) REFERENCES reservations (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D649D9A7F869 ON `user` (reservations_id)
        SQL);
    }
}
