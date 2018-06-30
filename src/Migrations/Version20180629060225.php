<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180629060225 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, image_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, summary LONGTEXT NOT NULL, content LONGTEXT NOT NULL, published TINYINT(1) NOT NULL, date DATE NOT NULL, update_at DATE DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, Category_id INT DEFAULT NULL, INDEX IDX_23A0E66F675F31B (author_id), INDEX IDX_23A0E6694DA1235 (Category_id), INDEX IDX_23A0E663DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, author_id INT DEFAULT NULL, content LONGTEXT NOT NULL, date DATE NOT NULL, updated_at DATE DEFAULT NULL, Article_id INT DEFAULT NULL, INDEX IDX_5F9E962A3DC9854C (Article_id), INDEX IDX_5F9E962A727ACA70 (parent_id), INDEX IDX_5F9E962AF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, location_id INT UNSIGNED DEFAULT NULL, image_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, date DATE NOT NULL, published_at DATE NOT NULL, updated_at DATE DEFAULT NULL, content LONGTEXT NOT NULL, summary LONGTEXT NOT NULL, slug VARCHAR(100) NOT NULL, INDEX IDX_3BAE0AA7F675F31B (author_id), INDEX IDX_3BAE0AA764D218E (location_id), INDEX IDX_3BAE0AA73DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, updated_at DATETIME NOT NULL, alt VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_original_name VARCHAR(255) DEFAULT NULL, image_mime_type VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, image_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE observation (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, image_id INT DEFAULT NULL, position_id INT DEFAULT NULL, verified_by_id INT DEFAULT NULL, species_id INT NOT NULL, description LONGTEXT NOT NULL, date DATE NOT NULL, updated_at DATE DEFAULT NULL, checked TINYINT(1) DEFAULT NULL, INDEX IDX_C576DBE0F675F31B (author_id), UNIQUE INDEX UNIQ_C576DBE03DA5256D (image_id), UNIQUE INDEX UNIQ_C576DBE0DD842E46 (position_id), INDEX IDX_C576DBE069F4B775 (verified_by_id), INDEX IDX_C576DBE0B2A1D860 (species_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position (id INT AUTO_INCREMENT NOT NULL, location_id INT UNSIGNED DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, date DATE NOT NULL, updateted_at DATE DEFAULT NULL, INDEX IDX_462CE4F564D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taxref (id INT AUTO_INCREMENT NOT NULL, famille VARCHAR(255) NOT NULL, lb_nom VARCHAR(255) NOT NULL, nom_fr VARCHAR(255) NOT NULL, obs_count INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, role VARCHAR(255) NOT NULL, first_name VARCHAR(35) NOT NULL, last_name VARCHAR(35) NOT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(32) NOT NULL, registration_date DATE NOT NULL, summary LONGTEXT NOT NULL, INDEX IDX_8D93D6493DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE villes_france_free (ville_id INT UNSIGNED AUTO_INCREMENT NOT NULL, ville_departement VARCHAR(3) DEFAULT NULL, ville_slug VARCHAR(255) DEFAULT NULL, ville_nom VARCHAR(45) DEFAULT NULL, ville_nom_simple VARCHAR(45) DEFAULT NULL, ville_nom_reel VARCHAR(45) DEFAULT NULL, ville_nom_soundex VARCHAR(20) DEFAULT NULL, ville_nom_metaphone VARCHAR(22) DEFAULT NULL, ville_code_postal VARCHAR(255) DEFAULT NULL, ville_commune VARCHAR(3) DEFAULT NULL, ville_code_commune VARCHAR(5) NOT NULL, ville_arrondissement SMALLINT UNSIGNED DEFAULT NULL, ville_canton VARCHAR(4) DEFAULT NULL, ville_amdi SMALLINT UNSIGNED DEFAULT NULL, ville_population_2010 INT UNSIGNED DEFAULT NULL, ville_population_1999 INT UNSIGNED DEFAULT NULL, ville_population_2012 INT UNSIGNED DEFAULT NULL COMMENT \'approximatif\', ville_densite_2010 INT DEFAULT NULL, ville_surface DOUBLE PRECISION DEFAULT NULL, ville_longitude_deg DOUBLE PRECISION DEFAULT NULL, ville_latitude_deg DOUBLE PRECISION DEFAULT NULL, ville_longitude_grd VARCHAR(9) DEFAULT NULL, ville_latitude_grd VARCHAR(8) DEFAULT NULL, ville_longitude_dms VARCHAR(9) DEFAULT NULL, ville_latitude_dms VARCHAR(8) DEFAULT NULL, ville_zmin INT DEFAULT NULL, ville_zmax INT DEFAULT NULL, INDEX ville_departement (ville_departement), INDEX ville_nom (ville_nom), INDEX ville_nom_reel (ville_nom_reel), INDEX ville_code_commune (ville_code_commune), INDEX ville_code_postal (ville_code_postal), INDEX ville_longitude_latitude_deg (ville_longitude_deg, ville_latitude_deg), INDEX ville_nom_soundex (ville_nom_soundex), INDEX ville_nom_metaphone (ville_nom_metaphone), INDEX ville_population_2010 (ville_population_2010), INDEX ville_nom_simple (ville_nom_simple), UNIQUE INDEX ville_slug (ville_slug), PRIMARY KEY(ville_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6694DA1235 FOREIGN KEY (Category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E663DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A3DC9854C FOREIGN KEY (Article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A727ACA70 FOREIGN KEY (parent_id) REFERENCES comments (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA764D218E FOREIGN KEY (location_id) REFERENCES villes_france_free (ville_id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA73DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE observation ADD CONSTRAINT FK_C576DBE0F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE observation ADD CONSTRAINT FK_C576DBE03DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE observation ADD CONSTRAINT FK_C576DBE0DD842E46 FOREIGN KEY (position_id) REFERENCES position (id)');
        $this->addSql('ALTER TABLE observation ADD CONSTRAINT FK_C576DBE069F4B775 FOREIGN KEY (verified_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE observation ADD CONSTRAINT FK_C576DBE0B2A1D860 FOREIGN KEY (species_id) REFERENCES taxref (id)');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F564D218E FOREIGN KEY (location_id) REFERENCES villes_france_free (ville_id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A3DC9854C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6694DA1235');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A727ACA70');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E663DA5256D');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA73DA5256D');
        $this->addSql('ALTER TABLE observation DROP FOREIGN KEY FK_C576DBE03DA5256D');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493DA5256D');
        $this->addSql('ALTER TABLE observation DROP FOREIGN KEY FK_C576DBE0DD842E46');
        $this->addSql('ALTER TABLE observation DROP FOREIGN KEY FK_C576DBE0B2A1D860');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66F675F31B');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AF675F31B');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7F675F31B');
        $this->addSql('ALTER TABLE observation DROP FOREIGN KEY FK_C576DBE0F675F31B');
        $this->addSql('ALTER TABLE observation DROP FOREIGN KEY FK_C576DBE069F4B775');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA764D218E');
        $this->addSql('ALTER TABLE position DROP FOREIGN KEY FK_462CE4F564D218E');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE observation');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE taxref');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE villes_france_free');
    }
}
