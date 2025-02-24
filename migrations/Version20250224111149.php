<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250224111149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create shipping tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE courier (
            id INT AUTO_INCREMENT NOT NULL,
            courier_name VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE shipping_rate (
            id INT AUTO_INCREMENT NOT NULL,
            courier_id INT NOT NULL,
            shipping_zone_id INT NOT NULL,
            shipping_rate_name VARCHAR(255) NOT NULL,
            PRIMARY KEY(id),
            CONSTRAINT FK_COURIER FOREIGN KEY (courier_id) REFERENCES courier (id),
            CONSTRAINT FK_SHIPPING_ZONE FOREIGN KEY (shipping_zone_id) REFERENCES shipping_zone (id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE shipping_zone (
            id INT AUTO_INCREMENT NOT NULL,
            courier_id INT NOT NULL,
            shipping_zone_name VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE courier');
        $this->addSql('DROP TABLE shipping_rate');
        $this->addSql('DROP TABLE shipping_zone');
    }
}
