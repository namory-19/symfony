<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220530134854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_deal (category_id INTEGER NOT NULL, deal_id INTEGER NOT NULL, PRIMARY KEY(category_id, deal_id))');
        $this->addSql('CREATE INDEX IDX_6865BB5112469DE2 ON category_deal (category_id)');
        $this->addSql('CREATE INDEX IDX_6865BB51F60E2305 ON category_deal (deal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category_deal');
    }
}
