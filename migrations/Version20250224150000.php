<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250224150000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insert Elden Ring-themed couriers, shipping zones, and shipping rates';
    }

    public function up(Schema $schema): void
    {
        // Insert Elden Ring-themed couriers (Courier Services)
        $this->addSql("
            INSERT INTO courier (courier_name) VALUES
            ('Erdtree Express'),
            ('Radahn’s War Couriers'),
            ('Leyndell Royal Mail'),
            ('Volcano Manor Deliveries'),
            ('Ranni’s Dark Moon Couriers')
        ");

        // Insert Elden Ring-themed shipping zones (Map Regions)
        $this->addSql("
            INSERT INTO shipping_zone (courier_id, shipping_zone_name) VALUES
            (1, 'Limgrave'),
            (2, 'Weeping Peninsula'),
            (3, 'Caelid'),
            (4, 'Altus Plateau'),
            (5, 'Leyndell, Royal Capital'),
            (6, 'Mt. Gelmir'),
            (7, 'Liurnia of the Lakes'),
            (8, 'Ainsel River'),
            (9, 'Siofra River'),
            (10, 'Deeproot Depths'),
            (11, 'Consecrated Snowfield'),
            (12, 'Lake of Rot'),
            (13, 'Mohgwyn Palace'),
            (14, 'Farum Azula')
        ");

        // Insert Elden Ring-themed shipping rates
        $this->addSql("
            INSERT INTO shipping_rate (courier_id, shipping_zone_id, shipping_rate_name, max_weight, max_value) VALUES
            (1, 1, 'Torrent Express - 1-Day Delivery', 5.00, 50.00),
            (1, 2, 'Golden Order Standard - 3-Day Delivery', 20.00, 200.00),
            (2, 3, 'Radahn’s War Freight', 100.00, 1000.00),
            (3, 4, 'Altus Gold Tier - Premium Delivery', 10.00, 500.00),
            (3, 5, 'Leyndell Capital Express', 25.00, 1000.00),
            (4, 6, 'Volcano Manor Secret Shipment', 50.00, 2000.00),
            (5, 7, 'Liurnia Moonlit Delivery', 10.00, 300.00),
            (5, 8, 'Ainsel River Ghost Couriers', 5.00, 150.00),
            (5, 9, 'Siofra River Lost Relic Transport', 20.00, 500.00),
            (5, 10, 'Deeproot Depths Hollow Freight', 50.00, 1000.00),
            (5, 11, 'Consecrated Snowfield Frost Express', 25.00, 800.00),
            (5, 12, 'Lake of Rot Hazardous Materials', 15.00, 1200.00),
            (5, 13, 'Mohgwyn Bloodstained Cargo', 30.00, 1500.00),
            (5, 14, 'Farum Azula Timeless Delivery', 100.00, 5000.00)
        ");
    }

    public function down(Schema $schema): void
    {
        // Rollback delete statements
        $this->addSql("DELETE FROM shipping_rate WHERE shipping_rate_name IN 
            ('Torrent Express - 1-Day Delivery', 'Golden Order Standard - 3-Day Delivery', 'Radahn’s War Freight', 
            'Altus Gold Tier - Premium Delivery', 'Leyndell Capital Express', 'Volcano Manor Secret Shipment', 
            'Liurnia Moonlit Delivery', 'Ainsel River Ghost Couriers', 'Siofra River Lost Relic Transport', 
            'Deeproot Depths Hollow Freight', 'Consecrated Snowfield Frost Express', 'Lake of Rot Hazardous Materials', 
            'Mohgwyn Bloodstained Cargo', 'Farum Azula Timeless Delivery')");

        $this->addSql("DELETE FROM shipping_zone WHERE shipping_zone_name IN 
            ('Limgrave', 'Weeping Peninsula', 'Caelid', 'Altus Plateau', 'Leyndell, Royal Capital', 'Mt. Gelmir', 
            'Liurnia of the Lakes', 'Ainsel River', 'Siofra River', 'Deeproot Depths', 'Consecrated Snowfield', 
            'Lake of Rot', 'Mohgwyn Palace', 'Farum Azula')");

        $this->addSql("DELETE FROM courier WHERE courier_name IN 
            ('Erdtree Express', 'Radahn’s War Couriers', 'Leyndell Royal Mail', 'Volcano Manor Deliveries', 'Ranni’s Dark Moon Couriers')");
    }
}
