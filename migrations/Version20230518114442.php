<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230518114442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE ingredients (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(50) NOT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\',
            updated_at DATETIME DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE recipes (
            id INT AUTO_INCREMENT NOT NULL,
            user INT DEFAULT NULL,
            title VARCHAR(100) NOT NULL,
            image_url VARCHAR(255) NOT NULL,
            description LONGTEXT NOT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\',
            updated_at DATETIME DEFAULT NULL,
            INDEX IDX_A369E2B58D93D649 (user),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE recipe_ingredient (
            recipe_id INT NOT NULL,
            ingredient_id INT NOT NULL,
            PRIMARY KEY(recipe_id, ingredient_id),
            INDEX IDX_C767EDF5FCF8192D (recipe_id),
            INDEX IDX_C767EDF5D4A2946 (ingredient_id),
            FOREIGN KEY (recipe_id) REFERENCES recipes (id) ON DELETE CASCADE,
            FOREIGN KEY (ingredient_id) REFERENCES ingredients (id) ON DELETE CASCADE
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE users (
            id INT AUTO_INCREMENT NOT NULL,
            username VARCHAR(50) NOT NULL,
            password VARCHAR(50) NOT NULL,
            name VARCHAR(50) NOT NULL,
            surname VARCHAR(50) DEFAULT NULL,
            email VARCHAR(50) NOT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\',
            updated_at DATETIME DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE recipes ADD CONSTRAINT FK_A369E2B58D93D649 FOREIGN KEY (user) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE recipes DROP FOREIGN KEY FK_A369E2B58D93D649');
        $this->addSql('DROP TABLE recipe_ingredient');
        $this->addSql('DROP TABLE recipes');
        $this->addSql('DROP TABLE ingredients');
        $this->addSql('DROP TABLE users');
    }
}
