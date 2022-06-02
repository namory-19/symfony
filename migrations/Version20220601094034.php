<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601094034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('DROP INDEX IDX_6865BB5112469DE2');
        $this->addSql('DROP INDEX IDX_6865BB51F60E2305');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_deal AS SELECT category_id, deal_id FROM category_deal');
        $this->addSql('DROP TABLE category_deal');
        $this->addSql('CREATE TABLE category_deal (category_id INTEGER NOT NULL, deal_id INTEGER NOT NULL, PRIMARY KEY(category_id, deal_id), CONSTRAINT FK_6865BB5112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6865BB51F60E2305 FOREIGN KEY (deal_id) REFERENCES deal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO category_deal (category_id, deal_id) SELECT category_id, deal_id FROM __temp__category_deal');
        $this->addSql('DROP TABLE __temp__category_deal');
        $this->addSql('CREATE INDEX IDX_6865BB5112469DE2 ON category_deal (category_id)');
        $this->addSql('CREATE INDEX IDX_6865BB51F60E2305 ON category_deal (deal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_6865BB5112469DE2');
        $this->addSql('DROP INDEX IDX_6865BB51F60E2305');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_deal AS SELECT category_id, deal_id FROM category_deal');
        $this->addSql('DROP TABLE category_deal');
        $this->addSql('CREATE TABLE category_deal (category_id INTEGER NOT NULL, deal_id INTEGER NOT NULL, PRIMARY KEY(category_id, deal_id))');
        $this->addSql('INSERT INTO category_deal (category_id, deal_id) SELECT category_id, deal_id FROM __temp__category_deal');
        $this->addSql('DROP TABLE __temp__category_deal');
        $this->addSql('CREATE INDEX IDX_6865BB5112469DE2 ON category_deal (category_id)');
        $this->addSql('CREATE INDEX IDX_6865BB51F60E2305 ON category_deal (deal_id)');
    }
}
