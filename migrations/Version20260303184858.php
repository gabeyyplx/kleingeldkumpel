<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260303184858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, symbol VARCHAR(5) NOT NULL, active BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE recurring_transaction (start_date DATE NOT NULL, last_applied DATE DEFAULT NULL, frequency_in_months INTEGER NOT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value NUMERIC(10, 2) NOT NULL, is_income BOOLEAN NOT NULL, category_id INTEGER DEFAULT NULL, user_id INTEGER NOT NULL, CONSTRAINT FK_D3509AA612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D3509AA6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D3509AA612469DE2 ON recurring_transaction (category_id)');
        $this->addSql('CREATE INDEX IDX_D3509AA6A76ED395 ON recurring_transaction (user_id)');
        $this->addSql('CREATE TABLE "transaction" (date DATE NOT NULL, id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value NUMERIC(10, 2) NOT NULL, is_income BOOLEAN NOT NULL, category_id INTEGER DEFAULT NULL, user_id INTEGER NOT NULL, CONSTRAINT FK_723705D112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_723705D1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_723705D112469DE2 ON "transaction" (category_id)');
        $this->addSql('CREATE INDEX IDX_723705D1A76ED395 ON "transaction" (user_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL, account_balance NUMERIC(10, 0) NOT NULL, locale VARCHAR(16) NOT NULL, currency VARCHAR(3) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON user (username)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 ON messenger_messages (queue_name, available_at, delivered_at, id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE recurring_transaction');
        $this->addSql('DROP TABLE "transaction"');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
