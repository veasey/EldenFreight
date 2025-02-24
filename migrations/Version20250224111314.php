<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250224111150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Populate shipping tables with Elden Ring-themed data';
    }

    public function up(Schema $schema): void
    {
        // Insert data into shipping_zone
        $this->addSql("INSERT INTO shipping_zone (zone_name) VALUES ('Limgrave')");
        $this->addSql("INSERT INTO shipping_zone (zone_name) VALUES ('Caelid')");
        $this->addSql("INSERT INTO shipping_zone (zone_name) VALUES ('Liurnia of the Lakes')");

        // Insert data into courier
        $this->addSql("INSERT INTO courier (name) VALUES ('Ranni Mail')");
        $this->addSql("INSERT INTO courier (name) VALUES ('Grafted Force')");
        $this->addSql("INSERT INTO courier (name) VALUES ('Two Fingers Freight')");

        // Insert data into shipping_rate
        // Assuming that shipping_zone with ids 1, 2, and 3 correspond to Limgrave, Caelid, and Liurnia respectively
        $this->addSql("INSERT INTO shipping_rate (rate, shipping_zone_id) VALUES (5.99, 1)"); // Limgrave
        $this->addSql("INSERT INTO shipping_rate (rate, shipping_zone_id) VALUES (7.99, 2)"); // Caelid
        $this->addSql("INSERT INTO shipping_rate (rate, shipping_zone_id) VALUES (6.49, 3)"); // Liurnia of the Lakes
    }

    public function down(Schema $schema): void
    {
        // Rollback the inserted data
        $this->addSql("DELETE FROM courier WHERE name IN ('Ranni Mail', 'Grafted Force', 'Two Fingers Freight')");
        $this->addSql("DELETE FROM shipping_zone WHERE zone_name IN ('Limgrave', 'Caelid', 'Liurnia of the Lakes')");
        $this->addSql("DELETE FROM shipping_rate WHERE rate IN (5.99, 7.99, 6.49)");
    }
}
