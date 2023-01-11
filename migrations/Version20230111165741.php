<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230111165741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand CHANGE brand_name brand_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE buyer CHANGE buyer_fio buyer_fio VARCHAR(255) NOT NULL, CHANGE buyer_passport_series buyer_passport_series VARCHAR(255) NOT NULL, CHANGE buyer_passport_number buyer_passport_number VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE manager CHANGE manager_fio manager_fio VARCHAR(255) NOT NULL');
        //$this->addSql('ALTER TABLE manufactor ADD manufactor_name VARCHAR(255) DEFAULT NULL, CHANGE manufactor_country manufactor_country VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE technical_data_id technical_data_id INT DEFAULT NULL, CHANGE model_name model_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product RENAME INDEX idx_d34a04ad3372b4f TO IDX_D34A04ADBD1FFA2A');
        $this->addSql('ALTER TABLE product RENAME INDEX idx_d34a04ad142e3c9d TO IDX_D34A04AD44F5D008');
        $this->addSql('ALTER TABLE product RENAME INDEX idx_d34a04adf7b4077 TO IDX_D34A04AD5BB9048D');
        $this->addSql('ALTER TABLE request CHANGE manager_id manager_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE request RENAME INDEX idx_3b978f9fddb4b4b4 TO IDX_3B978F9F783E3463');
        $this->addSql('ALTER TABLE request RENAME INDEX uniq_3b978f9fe00ee68d TO UNIQ_3B978F9F4584665A');
        $this->addSql('ALTER TABLE request RENAME INDEX uniq_3b978f9f3caebbb7 TO UNIQ_3B978F9F6C755722');
        $this->addSql('ALTER TABLE request_step DROP FOREIGN KEY FK_3C1ED9C622532272');
        $this->addSql('ALTER TABLE request_step DROP FOREIGN KEY FK_3C1ED9C6714819A0');
        $this->addSql('DROP INDEX UNIQ_3C1ED9C6714819A0 ON request_step');
        $this->addSql('DROP INDEX IDX_3C1ED9C622532272 ON request_step');
        $this->addSql('ALTER TABLE request_step ADD type_id INT NOT NULL, ADD request_id_id INT NOT NULL, DROP type_id, DROP request_id, CHANGE date date VARCHAR(40) NOT NULL');
        $this->addSql('ALTER TABLE request_step ADD CONSTRAINT FK_3C1ED9C622532272 FOREIGN KEY (request_id) REFERENCES request (id)');
        $this->addSql('ALTER TABLE request_step ADD CONSTRAINT FK_3C1ED9C6714819A0 FOREIGN KEY (type_id) REFERENCES request_type (id)');
        $this->addSql('CREATE INDEX IDX_3C1ED9C6714819A0 ON request_step (type_id)');
        $this->addSql('CREATE INDEX IDX_3C1ED9C622532272 ON request_step (request_id)');
        $this->addSql('ALTER TABLE technical_data CHANGE engine_type engine_type VARCHAR(255) NOT NULL, CHANGE engine_location engine_location VARCHAR(255) NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand CHANGE brand_name brand_name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE technical_data_id technical_data_id INT NOT NULL, CHANGE model_name model_name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE product RENAME INDEX idx_d34a04ad5bb9048d TO IDX_D34A04ADF7B4077');
        $this->addSql('ALTER TABLE product RENAME INDEX idx_d34a04ad44f5d008 TO IDX_D34A04AD142E3C9D');
        $this->addSql('ALTER TABLE product RENAME INDEX idx_d34a04adbd1ffa2a TO IDX_D34A04AD3372B4F');
        $this->addSql('ALTER TABLE request CHANGE manager_id manager_id INT NOT NULL, CHANGE product_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE request RENAME INDEX idx_3b978f9f783e3463 TO IDX_3B978F9FDDB4B4B4');
        $this->addSql('ALTER TABLE request RENAME INDEX uniq_3b978f9f6c755722 TO UNIQ_3B978F9F3CAEBBB7');
        $this->addSql('ALTER TABLE request RENAME INDEX uniq_3b978f9f4584665a TO UNIQ_3B978F9FE00EE68D');
        $this->addSql('ALTER TABLE manufactor DROP manufactor_name, CHANGE manufactor_country manufactor_country VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE request_step DROP FOREIGN KEY FK_3C1ED9C6714819A0');
        $this->addSql('ALTER TABLE request_step DROP FOREIGN KEY FK_3C1ED9C622532272');
        $this->addSql('DROP INDEX IDX_3C1ED9C6714819A0 ON request_step');
        $this->addSql('DROP INDEX IDX_3C1ED9C622532272 ON request_step');
        $this->addSql('ALTER TABLE request_step ADD type_id INT NOT NULL, ADD request_id INT NOT NULL, DROP type_id_id, DROP request_id_id, CHANGE date date DATE NOT NULL');
        $this->addSql('ALTER TABLE request_step ADD CONSTRAINT FK_3C1ED9C6714819A0 FOREIGN KEY (type_id) REFERENCES request_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE request_step ADD CONSTRAINT FK_3C1ED9C622532272 FOREIGN KEY (request_id) REFERENCES request (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3C1ED9C6714819A0 ON request_step (type_id)');
        $this->addSql('CREATE INDEX IDX_3C1ED9C622532272 ON request_step (request_id)');
        $this->addSql('ALTER TABLE manager CHANGE manager_fio manager_fio VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE technical_data CHANGE engine_type engine_type VARCHAR(50) NOT NULL, CHANGE engine_location engine_location VARCHAR(50) NOT NULL, CHANGE price price INT NOT NULL');
        $this->addSql('ALTER TABLE buyer CHANGE buyer_fio buyer_fio VARCHAR(70) NOT NULL, CHANGE buyer_passport_series buyer_passport_series VARCHAR(4) NOT NULL, CHANGE buyer_passport_number buyer_passport_number VARCHAR(6) NOT NULL');
    }
}
