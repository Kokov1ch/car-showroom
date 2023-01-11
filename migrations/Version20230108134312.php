<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108134312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, brand_name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE buyer (id INT AUTO_INCREMENT NOT NULL, buyer_fio VARCHAR(70) NOT NULL, buyer_passport_series VARCHAR(4) NOT NULL, buyer_passport_number VARCHAR(6) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manager (id INT AUTO_INCREMENT NOT NULL, manager_fio VARCHAR(100) NOT NULL, base_rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manufactor (id INT AUTO_INCREMENT NOT NULL, manufactor_country VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, id_manufactor_id INT NOT NULL, id_brand_id INT NOT NULL, id_body_type_id INT NOT NULL, availability TINYINT(1) NOT NULL, model_name VARCHAR(100) NOT NULL, INDEX IDX_D34A04AD3372B4F (id_manufactor_id), INDEX IDX_D34A04AD142E3C9D (id_brand_id), INDEX IDX_D34A04ADF7B4077 (id_body_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request (id INT AUTO_INCREMENT NOT NULL, id_manager_id INT NOT NULL, id_product_id INT NOT NULL, id_buyer_id INT DEFAULT NULL, INDEX IDX_3B978F9FDDB4B4B4 (id_manager_id), UNIQUE INDEX UNIQ_3B978F9FE00EE68D (id_product_id), UNIQUE INDEX UNIQ_3B978F9F3CAEBBB7 (id_buyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request_step (id INT AUTO_INCREMENT NOT NULL, type_id_id INT NOT NULL, request_id_id INT NOT NULL, date DATE NOT NULL, INDEX UNIQ_3C1ED9C6714819A0 (type_id_id), INDEX IDX_3C1ED9C622532272 (request_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request_type (id INT AUTO_INCREMENT NOT NULL, request_name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technical_data (id INT AUTO_INCREMENT NOT NULL, number_of_doors INT NOT NULL, number_of_seats INT NOT NULL, engine_type VARCHAR(50) NOT NULL, engine_location VARCHAR(50) NOT NULL, price INT NOT NULL, engine_volume DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD3372B4F FOREIGN KEY (id_manufactor_id) REFERENCES manufactor (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD142E3C9D FOREIGN KEY (id_brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF7B4077 FOREIGN KEY (id_body_type_id) REFERENCES technical_data (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FDDB4B4B4 FOREIGN KEY (id_manager_id) REFERENCES manager (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FE00EE68D FOREIGN KEY (id_product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9F3CAEBBB7 FOREIGN KEY (id_buyer_id) REFERENCES buyer (id)');
        $this->addSql('ALTER TABLE request_step ADD CONSTRAINT FK_3C1ED9C6714819A0 FOREIGN KEY (type_id_id) REFERENCES request_type (id)');
        $this->addSql('ALTER TABLE request_step ADD CONSTRAINT FK_3C1ED9C622532272 FOREIGN KEY (request_id_id) REFERENCES request (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3372B4F');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD142E3C9D');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADF7B4077');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FDDB4B4B4');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FE00EE68D');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9F3CAEBBB7');
        $this->addSql('ALTER TABLE request_step DROP FOREIGN KEY FK_3C1ED9C6714819A0');
        $this->addSql('ALTER TABLE request_step DROP FOREIGN KEY FK_3C1ED9C622532272');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE buyer');
        $this->addSql('DROP TABLE manager');
        $this->addSql('DROP TABLE manufactor');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE request');
        $this->addSql('DROP TABLE request_step');
        $this->addSql('DROP TABLE request_type');
        $this->addSql('DROP TABLE technical_data');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
