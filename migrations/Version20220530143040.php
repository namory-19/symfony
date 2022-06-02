<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220530143040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_6865BB51F60E2305');
        $this->addSql('DROP INDEX IDX_6865BB5112469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_deal AS SELECT category_id, deal_id FROM category_deal');
        $this->addSql('DROP TABLE category_deal');
        $this->addSql('CREATE TABLE category_deal (category_id INTEGER NOT NULL, deal_id INTEGER NOT NULL, PRIMARY KEY(category_id, deal_id), CONSTRAINT FK_6865BB5112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6865BB51F60E2305 FOREIGN KEY (deal_id) REFERENCES deal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO category_deal (category_id, deal_id) SELECT category_id, deal_id FROM __temp__category_deal');
        $this->addSql('DROP TABLE __temp__category_deal');
        $this->addSql('CREATE INDEX IDX_6865BB51F60E2305 ON category_deal (deal_id)');
        $this->addSql('CREATE INDEX IDX_6865BB5112469DE2 ON category_deal (category_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__deal AS SELECT id, name, description, created_at, updated_at, price, enable FROM deal');
        $this->addSql('DROP TABLE deal');
        $this->addSql('CREATE TABLE deal (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, price DOUBLE PRECISION NOT NULL, enable BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO deal (id, name, description, created_at, updated_at, price, enable) SELECT id, name, description, created_at, updated_at, price, enable FROM __temp__deal');
        $this->addSql('DROP TABLE __temp__deal');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_6865BB5112469DE2');
        $this->addSql('DROP INDEX IDX_6865BB51F60E2305');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_deal AS SELECT category_id, deal_id FROM category_deal');
        $this->addSql('DROP TABLE category_deal');
        $this->addSql('CREATE TABLE category_deal (category_id INTEGER NOT NULL, deal_id INTEGER NOT NULL, PRIMARY KEY(category_id, deal_id))');
        $this->addSql('INSERT INTO category_deal (category_id, deal_id) SELECT category_id, deal_id FROM __temp__category_deal');
        $this->addSql('DROP TABLE __temp__category_deal');
        $this->addSql('CREATE INDEX IDX_6865BB5112469DE2 ON category_deal (category_id)');
        $this->addSql('CREATE INDEX IDX_6865BB51F60E2305 ON category_deal (deal_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__deal AS SELECT id, name, description, created_at, updated_at, price, enable FROM deal');
        $this->addSql('DROP TABLE deal');
        $this->addSql('CREATE TABLE deal (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , price DOUBLE PRECISION NOT NULL, enable BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO deal (id, name, description, created_at, updated_at, price, enable) SELECT id, name, description, created_at, updated_at, price, enable FROM __temp__deal');
        $this->addSql('DROP TABLE __temp__deal');
    }
}
