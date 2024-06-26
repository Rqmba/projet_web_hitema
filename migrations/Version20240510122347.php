<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240510122347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Ajouter les colonnes pour les clés étrangères
        $this->addSql('ALTER TABLE order_details ADD orders_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_details ADD article_id INT NOT NULL');
        
        // Ajouter les contraintes de clé étrangère
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_ORDER_DETAILS_ORDERS FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_ORDER_DETAILS_ARTICLE FOREIGN KEY (article_id) REFERENCES article (id)');
        
        // Ajouter les index pour les clés étrangères
        $this->addSql('CREATE INDEX IDX_ORDER_DETAILS_ORDERS ON order_details (orders_id)');
        $this->addSql('CREATE INDEX IDX_ORDER_DETAILS_ARTICLE ON order_details (article_id)');
        
        // Ajouter la colonne pour la clé étrangère
        $this->addSql('ALTER TABLE orders ADD user_id INT NOT NULL');
        
        // Ajouter la contrainte de clé étrangère pour la colonne user_id
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_ORDERS_USER FOREIGN KEY (user_id) REFERENCES user (id)');
        
        // Ajouter l'index pour la clé étrangère user_id
        $this->addSql('CREATE INDEX IDX_ORDERS_USER ON orders (user_id)');
    }

    public function down(Schema $schema): void
    {
        // Supprimer la contrainte de clé étrangère pour la colonne user_id
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_ORDERS_USER');
        
        // Supprimer l'index pour la clé étrangère user_id
        $this->addSql('DROP INDEX IDX_ORDERS_USER ON orders');
        
        // Supprimer la colonne pour la clé étrangère user_id
        $this->addSql('ALTER TABLE orders DROP user_id');
        
        // Supprimer les index pour les clés étrangères
        $this->addSql('DROP INDEX IDX_ORDER_DETAILS_ORDERS ON order_details');
        $this->addSql('DROP INDEX IDX_ORDER_DETAILS_ARTICLE ON order_details');
        
        // Supprimer les contraintes de clé étrangère
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_ORDER_DETAILS_ORDERS');
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_ORDER_DETAILS_ARTICLE');
        
        // Supprimer les colonnes pour les clés étrangères
        $this->addSql('ALTER TABLE order_details DROP orders_id');
        $this->addSql('ALTER TABLE order_details DROP article_id');
    }
    
}
