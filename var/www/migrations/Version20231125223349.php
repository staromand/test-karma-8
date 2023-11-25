<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231125223349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_subscription (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, some_data_of_subscription VARCHAR(255) NOT NULL, validts INT NOT NULL, INDEX IDX_230A18D1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_subscription ADD CONSTRAINT FK_230A18D1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD confirmed_email TINYINT(1) DEFAULT 0 NOT NULL, ADD checked_email TINYINT(1) DEFAULT 0 NOT NULL, ADD valid_email TINYINT(1) DEFAULT 0 NOT NULL, DROP validts, DROP confirmed, DROP checked, DROP valid');
        $this->addSql('CREATE INDEX valid_email_idx ON user (valid_email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_subscription DROP FOREIGN KEY FK_230A18D1A76ED395');
        $this->addSql('DROP TABLE user_subscription');
        $this->addSql('DROP INDEX valid_email_idx ON user');
        $this->addSql('ALTER TABLE user ADD validts INT NOT NULL, ADD confirmed TINYINT(1) DEFAULT 0 NOT NULL, ADD checked TINYINT(1) DEFAULT 0 NOT NULL, ADD valid TINYINT(1) DEFAULT 0 NOT NULL, DROP confirmed_email, DROP checked_email, DROP valid_email');
    }
}
