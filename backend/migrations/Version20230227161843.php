<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227161843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE material (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, supplier_id INT DEFAULT NULL, is_available TINYINT(1) NOT NULL, budget VARCHAR(255) NOT NULL, bcnumber VARCHAR(255) NOT NULL, delevery_date DATE NOT NULL, end_of_guaranty_date DATE DEFAULT NULL, inventory_number VARCHAR(255) NOT NULL, INDEX IDX_7CBE7595A76ED395 (user_id), INDEX IDX_7CBE75952ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE7595A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE75952ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material DROP FOREIGN KEY FK_7CBE7595A76ED395');
        $this->addSql('ALTER TABLE material DROP FOREIGN KEY FK_7CBE75952ADD6D8C');
        $this->addSql('DROP TABLE material');
    }
}
