<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307140754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand_material DROP FOREIGN KEY FK_BB8EE68444F5D008');
        $this->addSql('ALTER TABLE brand_material DROP FOREIGN KEY FK_BB8EE684E308AC6F');
        $this->addSql('DROP TABLE brand_material');
        $this->addSql('ALTER TABLE material ADD brand_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE759544F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('CREATE INDEX IDX_7CBE759544F5D008 ON material (brand_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand_material (brand_id INT NOT NULL, material_id INT NOT NULL, INDEX IDX_BB8EE684E308AC6F (material_id), INDEX IDX_BB8EE68444F5D008 (brand_id), PRIMARY KEY(brand_id, material_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE brand_material ADD CONSTRAINT FK_BB8EE68444F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brand_material ADD CONSTRAINT FK_BB8EE684E308AC6F FOREIGN KEY (material_id) REFERENCES material (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE material DROP FOREIGN KEY FK_7CBE759544F5D008');
        $this->addSql('DROP INDEX IDX_7CBE759544F5D008 ON material');
        $this->addSql('ALTER TABLE material DROP brand_id');
    }
}
