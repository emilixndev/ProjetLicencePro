<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230301132426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE material_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE material_type_material (material_type_id INT NOT NULL, material_id INT NOT NULL, INDEX IDX_B14F2AFD74D6573C (material_type_id), INDEX IDX_B14F2AFDE308AC6F (material_id), PRIMARY KEY(material_type_id, material_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE material_type_material ADD CONSTRAINT FK_B14F2AFD74D6573C FOREIGN KEY (material_type_id) REFERENCES material_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE material_type_material ADD CONSTRAINT FK_B14F2AFDE308AC6F FOREIGN KEY (material_id) REFERENCES material (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material_type_material DROP FOREIGN KEY FK_B14F2AFD74D6573C');
        $this->addSql('ALTER TABLE material_type_material DROP FOREIGN KEY FK_B14F2AFDE308AC6F');
        $this->addSql('DROP TABLE material_type');
        $this->addSql('DROP TABLE material_type_material');
    }
}
