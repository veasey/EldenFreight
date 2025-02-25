<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version202502251245_InsertEldenRingData extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insert Elden Ring-themed shipping data';
    }

    public function up(Schema $schema): void
    {
        // Insert Elden Ring-themed couriers (Courier Services)
        $this->addSql("INSERT INTO courier (courier_name) VALUES
            ('Erdtree Express'),
            ('Radahn’s War Couriers'),
            ('Leyndell Royal Mail'),
            ('Volcano Manor Deliveries'),
            ('Ranni’s Dark Moon Couriers')
        ");

        // Insert Elden Ring-themed shipping zones (Map Regions)
        $this->addSql("INSERT INTO shipping_zone (courier_id, shipping_zone_name) VALUES
            (1, 'Limgrave'),
            (1, 'Weeping Peninsula'),
            (2, 'Caelid'),
            (3, 'Altus Plateau'),
            (3, 'Leyndell, Royal Capital'),
            (3, 'Mt. Gelmir'),
            (3, 'Liurnia of the Lakes'),
            (4, 'Ainsel River'),
            (4, 'Siofra River'),
            (4, 'Deeproot Depths'),
            (4, 'Consecrated Snowfield'),
            (5, 'Lake of Rot'),
            (5, 'Mohgwyn Palace'),
            (5, 'Farum Azula')
        ");

        // Insert Elden Ring-themed shipping rates for couriers that have shipping zones
        $this->addSql("INSERT INTO shipping_rate (courier_id, shipping_zone_id, shipping_rate_name, max_weight, max_value, price) VALUES
            (1, 1, 'Torrent Express - 1-Day Delivery', 5.00, 50.00, 10.00),
            (1, 2, 'Golden Order Standard - 3-Day Delivery', 20.00, 200.00, 20.00),
            (2, 3, 'Radahn’s War Freight', 100.00, 1000.00, 50.00),
            (3, 4, 'Altus Gold Tier - Premium Delivery', 10.00, 500.00, 15.00),
            (3, 5, 'Leyndell Capital Express', 25.00, 1000.00, 30.00),
            (4, 6, 'Volcano Manor Secret Shipment', 50.00, 2000.00, 70.00),
            (5, 7, 'Liurnia Moonlit Delivery', 10.00, 300.00, 10.00),
            (5, 8, 'Ainsel River Ghost Couriers', 5.00, 150.00, 5.00),
            (5, 9, 'Siofra River Lost Relic Transport', 20.00, 500.00, 25.00),
            (5, 10, 'Deeproot Depths Hollow Freight', 50.00, 1000.00, 60.00),
            (5, 11, 'Consecrated Snowfield Frost Express', 25.00, 800.00, 35.00),
            (5, 12, 'Lake of Rot Hazardous Materials', 15.00, 1200.00, 40.00),
            (5, 13, 'Mohgwyn Bloodstained Cargo', 30.00, 1500.00, 45.00),
            (5, 14, 'Farum Azula Timeless Delivery', 100.00, 5000.00, 100.00)
        ");

        // linker table
        $this->addSql("INSERT INTO shipping_rate_shipping_zone (shipping_rate_id, shipping_zone_id) VALUES
            (1, 1),  -- Torrent Express - 1-Day Delivery for Limgrave
            (1, 2),  -- Torrent Express - 1-Day Delivery for Weeping Peninsula
            (2, 3),  -- Radahn’s War Freight for Caelid
            (3, 4),  -- Altus Gold Tier - Premium Delivery for Altus Plateau
            (3, 5),  -- Leyndell Capital Express for Leyndell, Royal Capital
            (4, 6),  -- Volcano Manor Secret Shipment for Ainsel River
            (5, 7),  -- Liurnia Moonlit Delivery for Liurnia of the Lakes
            (5, 8),  -- Ainsel River Ghost Couriers for Siofra River
            (5, 9),  -- Siofra River Lost Relic Transport for Deeproot Depths
            (5, 10), -- Deeproot Depths Hollow Freight for Consecrated Snowfield
            (5, 11), -- Consecrated Snowfield Frost Express for Lake of Rot
            (5, 12), -- Lake of Rot Hazardous Materials for Mohgwyn Palace
            (5, 13), -- Mohgwyn Bloodstained Cargo for Farum Azula
            (5, 14)  -- Farum Azula Timeless Delivery for Farum Azula
        ");
    }

    public function down(Schema $schema): void
    {
        // No need to remove the data, just drop tables.
    }
}
