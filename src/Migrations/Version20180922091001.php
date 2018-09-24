<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180922091001 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE state DROP FOREIGN KEY FK_A393D2FB8EBC8AA1');
        $this->addSql('DROP INDEX UNIQ_A393D2FB8EBC8AA1 ON state');
        $this->addSql('ALTER TABLE state DROP shopping_cart_product_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE state ADD shopping_cart_product_id INT NOT NULL');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FB8EBC8AA1 FOREIGN KEY (shopping_cart_product_id) REFERENCES shopping_cart_product (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A393D2FB8EBC8AA1 ON state (shopping_cart_product_id)');
    }
}
