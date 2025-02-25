<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version202502251245_CreateShippingTables extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create shipping tables with relationships';
    }

    public function up(Schema $schema): void
    {
        // Create the courier table
        $this->addSql('CREATE TABLE IF NOT EXISTS courier (
            id INT AUTO_INCREMENT NOT NULL,
            courier_name VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');

        // Create the shipping_zone table
        $this->addSql('CREATE TABLE IF NOT EXISTS shipping_zone (
            id INT AUTO_INCREMENT NOT NULL,
            courier_id INT NOT NULL,
            shipping_zone_name VARCHAR(255) NOT NULL,
            PRIMARY KEY(id),
            CONSTRAINT FK_SHIPPING_ZONE_COURIER FOREIGN KEY (courier_id) REFERENCES courier (id) ON DELETE CASCADE
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');

        // Create the shipping_rate table
        $this->addSql('CREATE TABLE IF NOT EXISTS shipping_rate (
            id INT AUTO_INCREMENT NOT NULL,
            courier_id INT NOT NULL,
            shipping_zone_id INT NOT NULL,
            shipping_rate_name VARCHAR(255) NOT NULL,
            max_weight DECIMAL(6,2) NOT NULL,
            max_value DECIMAL(10,2) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            PRIMARY KEY(id),
            CONSTRAINT FK_SHIPPING_RATE_COURIER FOREIGN KEY (courier_id) REFERENCES courier (id) ON DELETE CASCADE,
            CONSTRAINT FK_SHIPPING_RATE_SHIPPING_ZONE FOREIGN KEY (shipping_zone_id) REFERENCES shipping_zone (id) ON DELETE CASCADE
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');

        // linker table
        $this->addSql('CREATE TABLE IF NOT EXISTS shipping_rate_shipping_zone (
            id INT AUTO_INCREMENT NOT NULL,
            shipping_rate_id INT NOT NULL,
            shipping_zone_id INT NOT NULL,
            PRIMARY KEY(id),
            CONSTRAINT FK_SHIPPING_RATE_SHIPPING_ZONE_SHIPPING_RATE FOREIGN KEY (shipping_rate_id) REFERENCES shipping_rate (id) ON DELETE CASCADE,
            CONSTRAINT FK_SHIPPING_RATE_SHIPPING_ZONE_SHIPPING_ZONE FOREIGN KEY (shipping_zone_id) REFERENCES shipping_zone (id) ON DELETE CASCADE
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
    }

    public function down(Schema $schema): void
    {
        // Drop the shipping_rate table
        $this->addSql('DROP TABLE shipping_rate');

        // Drop the shipping_zone table
        $this->addSql('DROP TABLE shipping_zone');

        // Drop the courier table
        $this->addSql('DROP TABLE courier');

        // Drop linker table
        $this->addSql('DROP TABLE shipping_rate_shipping_zone');
    }
}
