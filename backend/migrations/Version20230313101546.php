<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230313101546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE img_material (id INT AUTO_INCREMENT NOT NULL, material_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_D222709BE308AC6F (material_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE img_material ADD CONSTRAINT FK_D222709BE308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE img_material DROP FOREIGN KEY FK_D222709BE308AC6F');
        $this->addSql('DROP TABLE img_material');
    }
}
