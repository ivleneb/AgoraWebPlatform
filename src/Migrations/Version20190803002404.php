<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190803002404 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE donation (id INT AUTO_INCREMENT NOT NULL, registered_by_id INT NOT NULL, name VARCHAR(150) NOT NULL, lastname VARCHAR(100) NOT NULL, amount NUMERIC(8, 2) NOT NULL, description VARCHAR(100) NOT NULL, register_date DATETIME NOT NULL, INDEX IDX_31E581A027E92E18 (registered_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fees_value (id INT AUTO_INCREMENT NOT NULL, amount NUMERIC(5, 2) NOT NULL, created_at DATETIME NOT NULL, description VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, registered_by_id INT NOT NULL, name VARCHAR(50) NOT NULL, father_lastname VARCHAR(50) NOT NULL, mother_lastname VARCHAR(50) NOT NULL, birthdate DATE NOT NULL, address VARCHAR(255) NOT NULL, district VARCHAR(50) NOT NULL, province VARCHAR(50) NOT NULL, region VARCHAR(50) NOT NULL, degree_of_instruction VARCHAR(50) NOT NULL, civil_status VARCHAR(10) NOT NULL, dni INT NOT NULL, cellphone_number INT NOT NULL, non_virtual_register TINYINT(1) NOT NULL, register_date DATE NOT NULL, INDEX IDX_70E4FA7827E92E18 (registered_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_donation (id INT AUTO_INCREMENT NOT NULL, member_id INT NOT NULL, registered_by_id INT NOT NULL, amount NUMERIC(8, 2) NOT NULL, description VARCHAR(50) NOT NULL, register_date DATETIME NOT NULL, INDEX IDX_C638224A7597D3FE (member_id), INDEX IDX_C638224A27E92E18 (registered_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membership_fees (id INT AUTO_INCREMENT NOT NULL, member_id INT NOT NULL, registered_by_id INT NOT NULL, register_date DATETIME NOT NULL, INDEX IDX_DBACF4A77597D3FE (member_id), INDEX IDX_DBACF4A727E92E18 (registered_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(50) NOT NULL, username VARCHAR(25) NOT NULL, name VARCHAR(150) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A027E92E18 FOREIGN KEY (registered_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA7827E92E18 FOREIGN KEY (registered_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE member_donation ADD CONSTRAINT FK_C638224A7597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE member_donation ADD CONSTRAINT FK_C638224A27E92E18 FOREIGN KEY (registered_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE membership_fees ADD CONSTRAINT FK_DBACF4A77597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE membership_fees ADD CONSTRAINT FK_DBACF4A727E92E18 FOREIGN KEY (registered_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member_donation DROP FOREIGN KEY FK_C638224A7597D3FE');
        $this->addSql('ALTER TABLE membership_fees DROP FOREIGN KEY FK_DBACF4A77597D3FE');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A027E92E18');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA7827E92E18');
        $this->addSql('ALTER TABLE member_donation DROP FOREIGN KEY FK_C638224A27E92E18');
        $this->addSql('ALTER TABLE membership_fees DROP FOREIGN KEY FK_DBACF4A727E92E18');
        $this->addSql('DROP TABLE donation');
        $this->addSql('DROP TABLE fees_value');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE member_donation');
        $this->addSql('DROP TABLE membership_fees');
        $this->addSql('DROP TABLE user');
    }
}
