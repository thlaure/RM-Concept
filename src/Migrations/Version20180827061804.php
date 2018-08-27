<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180827061804 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, color_id INT NOT NULL, name VARCHAR(255) NOT NULL, reference VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, is_new TINYINT(1) NOT NULL, quantity INT NOT NULL, price_individuals DOUBLE PRECISION NOT NULL, price_professionals DOUBLE PRECISION NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_D34A04AD7ADA1FB5 (color_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, postal_code VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color_code VARCHAR(7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command (id INT AUTO_INCREMENT NOT NULL, haulier_id INT DEFAULT NULL, customer_id INT NOT NULL, shopping_cart_id INT DEFAULT NULL, date DATETIME NOT NULL, total_price DOUBLE PRECISION NOT NULL, reference VARCHAR(255) NOT NULL, delivery_address VARCHAR(255) NOT NULL, delivery_complement_address VARCHAR(255) DEFAULT NULL, delivery_city VARCHAR(255) NOT NULL, delivery_postal_code VARCHAR(5) NOT NULL, is_paid TINYINT(1) NOT NULL, INDEX IDX_8ECAEAD4E41BD2EA (haulier_id), INDEX IDX_8ECAEAD49395C3F3 (customer_id), UNIQUE INDEX UNIQ_8ECAEAD445F80CD (shopping_cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, shopping_cart_not_confirmed_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, reference VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(10) NOT NULL, address VARCHAR(255) NOT NULL, address_complement VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(5) NOT NULL, city VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_81398E094FBF040 (shopping_cart_not_confirmed_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE haulier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_method (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopping_cart (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, command_id INT DEFAULT NULL, total_price DOUBLE PRECISION NOT NULL, product_quantity INT NOT NULL, is_confirmed TINYINT(1) NOT NULL, is_saved TINYINT(1) NOT NULL, confirmed VARCHAR(255) NOT NULL, INDEX IDX_72AAD4F69395C3F3 (customer_id), INDEX IDX_72AAD4F633E1689A (command_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopping_cart_product (id INT AUTO_INCREMENT NOT NULL, shopping_cart_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, is_customized TINYINT(1) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_FA1F5E6C45F80CD (shopping_cart_id), INDEX IDX_FA1F5E6C4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4E41BD2EA FOREIGN KEY (haulier_id) REFERENCES haulier (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD49395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD445F80CD FOREIGN KEY (shopping_cart_id) REFERENCES shopping_cart (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E094FBF040 FOREIGN KEY (shopping_cart_not_confirmed_id) REFERENCES shopping_cart (id)');
        $this->addSql('ALTER TABLE shopping_cart ADD CONSTRAINT FK_72AAD4F69395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE shopping_cart ADD CONSTRAINT FK_72AAD4F633E1689A FOREIGN KEY (command_id) REFERENCES command (id)');
        $this->addSql('ALTER TABLE shopping_cart_product ADD CONSTRAINT FK_FA1F5E6C45F80CD FOREIGN KEY (shopping_cart_id) REFERENCES shopping_cart (id)');
        $this->addSql('ALTER TABLE shopping_cart_product ADD CONSTRAINT FK_FA1F5E6C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shopping_cart_product DROP FOREIGN KEY FK_FA1F5E6C4584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD7ADA1FB5');
        $this->addSql('ALTER TABLE shopping_cart DROP FOREIGN KEY FK_72AAD4F633E1689A');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD49395C3F3');
        $this->addSql('ALTER TABLE shopping_cart DROP FOREIGN KEY FK_72AAD4F69395C3F3');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4E41BD2EA');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD445F80CD');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E094FBF040');
        $this->addSql('ALTER TABLE shopping_cart_product DROP FOREIGN KEY FK_FA1F5E6C45F80CD');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE command');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE haulier');
        $this->addSql('DROP TABLE payment_method');
        $this->addSql('DROP TABLE shopping_cart');
        $this->addSql('DROP TABLE shopping_cart_product');
    }
}
