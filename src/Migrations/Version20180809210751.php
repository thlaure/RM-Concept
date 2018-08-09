<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180809210751 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ball (id INT AUTO_INCREMENT NOT NULL, color_id INT NOT NULL, name VARCHAR(255) NOT NULL, reference VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, is_new TINYINT(1) NOT NULL, quantity INT NOT NULL, price_individuals DOUBLE PRECISION NOT NULL, price_professionals DOUBLE PRECISION NOT NULL, INDEX IDX_7432485B7ADA1FB5 (color_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color_code VARCHAR(7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE individual (id INT AUTO_INCREMENT NOT NULL, shopping_cart_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, reference VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(10) NOT NULL, address VARCHAR(255) NOT NULL, address_complement VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(5) NOT NULL, city VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8793FC1745F80CD (shopping_cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopping_cart (id INT AUTO_INCREMENT NOT NULL, creation_date DATETIME NOT NULL, total_price DOUBLE PRECISION NOT NULL, product_quantity INT NOT NULL, is_confirmed TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopping_cart_product (shopping_cart_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_FA1F5E6C45F80CD (shopping_cart_id), INDEX IDX_FA1F5E6C4584665A (product_id), PRIMARY KEY(shopping_cart_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ball ADD CONSTRAINT FK_7432485B7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE individual ADD CONSTRAINT FK_8793FC1745F80CD FOREIGN KEY (shopping_cart_id) REFERENCES shopping_cart (id)');
        $this->addSql('ALTER TABLE shopping_cart_product ADD CONSTRAINT FK_FA1F5E6C45F80CD FOREIGN KEY (shopping_cart_id) REFERENCES shopping_cart (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ball DROP FOREIGN KEY FK_7432485B7ADA1FB5');
        $this->addSql('ALTER TABLE individual DROP FOREIGN KEY FK_8793FC1745F80CD');
        $this->addSql('ALTER TABLE shopping_cart_product DROP FOREIGN KEY FK_FA1F5E6C45F80CD');
        $this->addSql('DROP TABLE ball');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE individual');
        $this->addSql('DROP TABLE shopping_cart');
        $this->addSql('DROP TABLE shopping_cart_product');
    }
}
