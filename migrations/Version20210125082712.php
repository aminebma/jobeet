<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210125082712 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE affiliates_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE categories_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE jobs_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE affiliates (id INT NOT NULL, url VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_108C6A8F5F37A13B ON affiliates (token)');
        $this->addSql('CREATE TABLE affiliates_categories (affiliate_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(affiliate_id, category_id))');
        $this->addSql('CREATE INDEX IDX_87BE21809F12C49A ON affiliates_categories (affiliate_id)');
        $this->addSql('CREATE INDEX IDX_87BE218012469DE2 ON affiliates_categories (category_id)');
        $this->addSql('CREATE TABLE categories (id INT NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3AF34668989D9B62 ON categories (slug)');
        $this->addSql('CREATE TABLE jobs (id INT NOT NULL, category_id INT NOT NULL, type VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, position VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, description TEXT NOT NULL, how_to_apply TEXT NOT NULL, token VARCHAR(255) NOT NULL, public BOOLEAN NOT NULL, activated BOOLEAN NOT NULL, email VARCHAR(255) NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A8936DC55F37A13B ON jobs (token)');
        $this->addSql('CREATE INDEX IDX_A8936DC512469DE2 ON jobs (category_id)');
        $this->addSql('ALTER TABLE affiliates_categories ADD CONSTRAINT FK_87BE21809F12C49A FOREIGN KEY (affiliate_id) REFERENCES affiliates (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE affiliates_categories ADD CONSTRAINT FK_87BE218012469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE jobs ADD CONSTRAINT FK_A8936DC512469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE affiliates_categories DROP CONSTRAINT FK_87BE21809F12C49A');
        $this->addSql('ALTER TABLE affiliates_categories DROP CONSTRAINT FK_87BE218012469DE2');
        $this->addSql('ALTER TABLE jobs DROP CONSTRAINT FK_A8936DC512469DE2');
        $this->addSql('DROP SEQUENCE affiliates_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE categories_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE jobs_id_seq CASCADE');
        $this->addSql('DROP TABLE affiliates');
        $this->addSql('DROP TABLE affiliates_categories');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE jobs');
    }
}
