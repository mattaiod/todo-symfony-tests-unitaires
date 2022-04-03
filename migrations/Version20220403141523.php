<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220403141523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE item_to_do_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE to_do_list_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE item_to_do (id INT NOT NULL, to_do_list_id INT NOT NULL, name VARCHAR(255) NOT NULL, content TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_38EEF670B3AB48EB ON item_to_do (to_do_list_id)');
        $this->addSql('COMMENT ON COLUMN item_to_do.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE to_do_list (id INT NOT NULL, user_app_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4A6048EC1CD53A10 ON to_do_list (user_app_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(40) NOT NULL, age INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE item_to_do ADD CONSTRAINT FK_38EEF670B3AB48EB FOREIGN KEY (to_do_list_id) REFERENCES to_do_list (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE to_do_list ADD CONSTRAINT FK_4A6048EC1CD53A10 FOREIGN KEY (user_app_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE item_to_do DROP CONSTRAINT FK_38EEF670B3AB48EB');
        $this->addSql('ALTER TABLE to_do_list DROP CONSTRAINT FK_4A6048EC1CD53A10');
        $this->addSql('DROP SEQUENCE item_to_do_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE to_do_list_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE item_to_do');
        $this->addSql('DROP TABLE to_do_list');
        $this->addSql('DROP TABLE "user"');
    }
}
