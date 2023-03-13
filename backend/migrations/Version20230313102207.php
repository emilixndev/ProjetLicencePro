<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230313102207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budget (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE material ADD budget_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE759536ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id)');
        $this->addSql('CREATE INDEX IDX_7CBE759536ABA6B8 ON material (budget_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material DROP FOREIGN KEY FK_7CBE759536ABA6B8');
        $this->addSql('DROP TABLE budget');
        $this->addSql('DROP INDEX IDX_7CBE759536ABA6B8 ON material');
        $this->addSql('ALTER TABLE material DROP budget_id');
    }
}
