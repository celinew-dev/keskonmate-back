<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211102130148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actor (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(128) NOT NULL, lastname VARCHAR(128) NOT NULL, image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_835033F85E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, series_id INT DEFAULT NULL, season_number INT DEFAULT NULL, number_of_episodes INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F0E45BA95278319C (series_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE series (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, synopsis LONGTEXT NOT NULL, release_date DATE NOT NULL, image VARCHAR(255) DEFAULT NULL, director VARCHAR(255) NOT NULL, number_of_seasons INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE series_user_list (series_id INT NOT NULL, user_list_id INT NOT NULL, INDEX IDX_AEA542D85278319C (series_id), INDEX IDX_AEA542D865A30881 (user_list_id), PRIMARY KEY(series_id, user_list_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE series_genre (series_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_F6DFD7E55278319C (series_id), INDEX IDX_F6DFD7E54296D31F (genre_id), PRIMARY KEY(series_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE series_actor (series_id INT NOT NULL, actor_id INT NOT NULL, INDEX IDX_31FAB2E45278319C (series_id), INDEX IDX_31FAB2E410DAF24A (actor_id), PRIMARY KEY(series_id, actor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_list (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, season_nb INT DEFAULT NULL, series_nb INT DEFAULT NULL, episode_nb INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', type SMALLINT NOT NULL, INDEX IDX_3E49B4D167B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA95278319C FOREIGN KEY (series_id) REFERENCES series (id)');
        $this->addSql('ALTER TABLE series_user_list ADD CONSTRAINT FK_AEA542D85278319C FOREIGN KEY (series_id) REFERENCES series (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE series_user_list ADD CONSTRAINT FK_AEA542D865A30881 FOREIGN KEY (user_list_id) REFERENCES user_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE series_genre ADD CONSTRAINT FK_F6DFD7E55278319C FOREIGN KEY (series_id) REFERENCES series (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE series_genre ADD CONSTRAINT FK_F6DFD7E54296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE series_actor ADD CONSTRAINT FK_31FAB2E45278319C FOREIGN KEY (series_id) REFERENCES series (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE series_actor ADD CONSTRAINT FK_31FAB2E410DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_list ADD CONSTRAINT FK_3E49B4D167B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE series_actor DROP FOREIGN KEY FK_31FAB2E410DAF24A');
        $this->addSql('ALTER TABLE series_genre DROP FOREIGN KEY FK_F6DFD7E54296D31F');
        $this->addSql('ALTER TABLE season DROP FOREIGN KEY FK_F0E45BA95278319C');
        $this->addSql('ALTER TABLE series_user_list DROP FOREIGN KEY FK_AEA542D85278319C');
        $this->addSql('ALTER TABLE series_genre DROP FOREIGN KEY FK_F6DFD7E55278319C');
        $this->addSql('ALTER TABLE series_actor DROP FOREIGN KEY FK_31FAB2E45278319C');
        $this->addSql('ALTER TABLE user_list DROP FOREIGN KEY FK_3E49B4D167B3B43D');
        $this->addSql('ALTER TABLE series_user_list DROP FOREIGN KEY FK_AEA542D865A30881');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE series');
        $this->addSql('DROP TABLE series_user_list');
        $this->addSql('DROP TABLE series_genre');
        $this->addSql('DROP TABLE series_actor');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_list');
    }
}
