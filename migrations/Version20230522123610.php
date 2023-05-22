<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230522123610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration creates recipe entity with OneToMany collection of ingredients';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE ingredients (guid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_4B60114F5E237E06 (name), PRIMARY KEY(guid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipes (guid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', user CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(128) NOT NULL, image_url VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_A369E2B52B36786B (title), INDEX IDX_A369E2B58D93D649 (user), PRIMARY KEY(guid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (guid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', username VARCHAR(64) NOT NULL, password VARCHAR(64) NOT NULL, name VARCHAR(64) NOT NULL, surname VARCHAR(64) DEFAULT NULL, email VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(guid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipes ADD CONSTRAINT FK_A369E2B58D93D649 FOREIGN KEY (user) REFERENCES users (guid)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE recipes DROP FOREIGN KEY FK_A369E2B58D93D649');
        $this->addSql('DROP TABLE ingredients');
        $this->addSql('DROP TABLE recipes');
        $this->addSql('DROP TABLE users');
    }
}
