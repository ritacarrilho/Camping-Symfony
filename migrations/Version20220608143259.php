<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608143259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invoices (id INT AUTO_INCREMENT NOT NULL, reservation_id_id INT NOT NULL, invoice_date DATE NOT NULL, price_unity DOUBLE PRECISION NOT NULL, days_number INT NOT NULL, invoice_reference INT NOT NULL, INDEX IDX_6A2F2F953C3B4EF0 (reservation_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoices_info (id INT AUTO_INCREMENT NOT NULL, invoice_id_id INT DEFAULT NULL, designation VARCHAR(255) NOT NULL, emition_date DATE NOT NULL, price_unity DOUBLE PRECISION NOT NULL, INDEX IDX_DB18D4B4429ECEE2 (invoice_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owners (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, contract_number INT NOT NULL, end_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rental_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, capacity INT NOT NULL, daily_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rentals (id INT AUTO_INCREMENT NOT NULL, type_id_id INT NOT NULL, owner_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, reference INT NOT NULL, picture VARCHAR(100) NOT NULL, INDEX IDX_35ACDB48714819A0 (type_id_id), INDEX IDX_35ACDB488FDDAB70 (owner_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, rental_id_id INT NOT NULL, client_name VARCHAR(255) NOT NULL, checkin DATE NOT NULL, checkout DATE NOT NULL, adults_nbr INT NOT NULL, kids_nbr INT NOT NULL, kids_pool INT NOT NULL, adults_pool INT NOT NULL, year_save TINYINT(1) NOT NULL, INDEX IDX_4DA239E4AF10B8 (rental_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(150) NOT NULL, per_day INT NOT NULL, consumer_type VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, owner_id_id INT NOT NULL, email VARCHAR(200) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D6498FDDAB70 (owner_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoices ADD CONSTRAINT FK_6A2F2F953C3B4EF0 FOREIGN KEY (reservation_id_id) REFERENCES reservations (id)');
        $this->addSql('ALTER TABLE invoices_info ADD CONSTRAINT FK_DB18D4B4429ECEE2 FOREIGN KEY (invoice_id_id) REFERENCES invoices (id)');
        $this->addSql('ALTER TABLE rentals ADD CONSTRAINT FK_35ACDB48714819A0 FOREIGN KEY (type_id_id) REFERENCES rental_type (id)');
        $this->addSql('ALTER TABLE rentals ADD CONSTRAINT FK_35ACDB488FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES owners (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239E4AF10B8 FOREIGN KEY (rental_id_id) REFERENCES rentals (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES owners (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoices_info DROP FOREIGN KEY FK_DB18D4B4429ECEE2');
        $this->addSql('ALTER TABLE rentals DROP FOREIGN KEY FK_35ACDB488FDDAB70');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498FDDAB70');
        $this->addSql('ALTER TABLE rentals DROP FOREIGN KEY FK_35ACDB48714819A0');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239E4AF10B8');
        $this->addSql('ALTER TABLE invoices DROP FOREIGN KEY FK_6A2F2F953C3B4EF0');
        $this->addSql('DROP TABLE invoices');
        $this->addSql('DROP TABLE invoices_info');
        $this->addSql('DROP TABLE owners');
        $this->addSql('DROP TABLE rental_type');
        $this->addSql('DROP TABLE rentals');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE user');
    }
}
