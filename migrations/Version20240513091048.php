<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513091048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_ORDER_DETAILS_ARTICLE');
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_ORDER_DETAILS_ORDERS');
        $this->addSql('DROP INDEX IDX_ORDER_DETAILS_ORDERS ON order_details');
        $this->addSql('DROP INDEX IDX_ORDER_DETAILS_ARTICLE ON order_details');
        $this->addSql('ALTER TABLE order_details ADD orders_id_id INT NOT NULL, ADD article_id_id INT NOT NULL, DROP orders_id, DROP article_id');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C13EEE31F6 FOREIGN KEY (orders_id_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C18F3EC46 FOREIGN KEY (article_id_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_845CA2C13EEE31F6 ON order_details (orders_id_id)');
        $this->addSql('CREATE INDEX IDX_845CA2C18F3EC46 ON order_details (article_id_id)');
        $this->addSql('ALTER TABLE orders ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEE9D86650F ON orders (user_id_id)');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_orders_user TO IDX_E52FFDEEA76ED395');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE9D86650F');
        $this->addSql('DROP INDEX IDX_E52FFDEE9D86650F ON orders');
        $this->addSql('ALTER TABLE orders DROP user_id_id');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_e52ffdeea76ed395 TO IDX_ORDERS_USER');
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_845CA2C13EEE31F6');
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_845CA2C18F3EC46');
        $this->addSql('DROP INDEX IDX_845CA2C13EEE31F6 ON order_details');
        $this->addSql('DROP INDEX IDX_845CA2C18F3EC46 ON order_details');
        $this->addSql('ALTER TABLE order_details ADD orders_id INT NOT NULL, ADD article_id INT NOT NULL, DROP orders_id_id, DROP article_id_id');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_ORDER_DETAILS_ARTICLE FOREIGN KEY (article_id) REFERENCES article (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_ORDER_DETAILS_ORDERS FOREIGN KEY (orders_id) REFERENCES orders (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_ORDER_DETAILS_ORDERS ON order_details (orders_id)');
        $this->addSql('CREATE INDEX IDX_ORDER_DETAILS_ARTICLE ON order_details (article_id)');
    }
}
