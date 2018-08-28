<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180828221910 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer ADD shopping_cart_not_confirmed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E094FBF040 FOREIGN KEY (shopping_cart_not_confirmed_id) REFERENCES shopping_cart (id)');
        $this->addSql('CREATE INDEX IDX_81398E094FBF040 ON customer (shopping_cart_not_confirmed_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E094FBF040');
        $this->addSql('DROP INDEX IDX_81398E094FBF040 ON customer');
        $this->addSql('ALTER TABLE customer DROP shopping_cart_not_confirmed_id');
    }
}
