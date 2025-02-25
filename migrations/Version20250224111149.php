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
        return 'Create shipping tables with corrected relationships';
    }

    public function up(Schema $schema): void
    {
        // Create the courier table
        $this->addSql('CREATE TABLE courier (
            id INT AUTO_INCREMENT NOT NULL,
            courier_name VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');

        // Create the shipping_zone table
        $this->addSql('CREATE TABLE shipping_zone (
            id INT AUTO_INCREMENT NOT NULL,
            shipping_zone_name VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');

        // Create the shipping_rate table
        $this->addSql('CREATE TABLE shipping_rate (
            id INT AUTO_INCREMENT NOT NULL,
            courier_id INT NOT NULL,
            shipping_zone_id INT NOT NULL,
            shipping_rate_name VARCHAR(255) NOT NULL,
            max_weight DECIMAL(6,2) NOT NULL,
            max_value DECIMAL(10,2) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            PRIMARY KEY(id),
            CONSTRAINT FK_COURIER FOREIGN KEY (courier_id) REFERENCES courier (id) ON DELETE CASCADE,
            CONSTRAINT FK_SHIPPING_ZONE FOREIGN KEY (shipping_zone_id) REFERENCES shipping_zone (id) ON DELETE CASCADE
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
    }

    public function down(Schema $schema): void
    {
        // Drop the shipping_rate table first due to foreign key constraints
        $this->addSql('DROP TABLE shipping_rate');

        // Drop the courier and shipping_zone tables
        $this->addSql('DROP TABLE courier');
        $this->addSql('DROP TABLE shipping_zone');
    }
}
