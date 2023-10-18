<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231018122411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etats (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscriptions (id INT AUTO_INCREMENT NOT NULL, participant_idparticipant_id INT DEFAULT NULL, sortie_idsortie_id INT DEFAULT NULL, date_inscription DATE NOT NULL, UNIQUE INDEX UNIQ_74E0281C49100234 (participant_idparticipant_id), UNIQUE INDEX UNIQ_74E0281C8322D61A (sortie_idsortie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieux (id INT AUTO_INCREMENT NOT NULL, ville_idville_id INT NOT NULL, nom VARCHAR(50) NOT NULL, rue VARCHAR(50) NOT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, INDEX IDX_9E44A8AED3B6AC32 (ville_idville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participants (id INT AUTO_INCREMENT NOT NULL, site_idsite_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, telephone VARCHAR(50) DEFAULT NULL, administrateur TINYINT(1) NOT NULL, actif TINYINT(1) NOT NULL, is_verified TINYINT(1) NOT NULL, photo_profil VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_71697092E7927C74 (email), UNIQUE INDEX UNIQ_7169709286CC499D (pseudo), INDEX IDX_716970924FB3325D (site_idsite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sites (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sorties (id INT AUTO_INCREMENT NOT NULL, participant_idparticipant_id INT DEFAULT NULL, site_idsite_id INT NOT NULL, lieu_idlieu_id INT NOT NULL, etat_idetat_id INT NOT NULL, nom VARCHAR(50) NOT NULL, date_heure_debut DATE NOT NULL, duree INT DEFAULT NULL, date_limite_inscription DATE NOT NULL, nombre_inscription_max INT NOT NULL, info_sorties VARCHAR(500) NOT NULL, motif_annulation VARCHAR(255) NOT NULL, photo_sorties VARCHAR(255) NOT NULL, INDEX IDX_488163E849100234 (participant_idparticipant_id), INDEX IDX_488163E84FB3325D (site_idsite_id), INDEX IDX_488163E8DAD1DA15 (lieu_idlieu_id), INDEX IDX_488163E822C8927D (etat_idetat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sorties_participants (participant_id INT NOT NULL, participants_id INT NOT NULL, INDEX IDX_BB662DEC9D1C3019 (participant_id), INDEX IDX_BB662DEC838709D5 (participants_id), PRIMARY KEY(participant_id, participants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE villes (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, code_postal VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281C49100234 FOREIGN KEY (participant_idparticipant_id) REFERENCES participants (id)');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281C8322D61A FOREIGN KEY (sortie_idsortie_id) REFERENCES sorties (id)');
        $this->addSql('ALTER TABLE lieux ADD CONSTRAINT FK_9E44A8AED3B6AC32 FOREIGN KEY (ville_idville_id) REFERENCES villes (id)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_716970924FB3325D FOREIGN KEY (site_idsite_id) REFERENCES sites (id)');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E849100234 FOREIGN KEY (participant_idparticipant_id) REFERENCES participants (id)');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E84FB3325D FOREIGN KEY (site_idsite_id) REFERENCES sites (id)');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E8DAD1DA15 FOREIGN KEY (lieu_idlieu_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E822C8927D FOREIGN KEY (etat_idetat_id) REFERENCES etats (id)');
        $this->addSql('ALTER TABLE sorties_participants ADD CONSTRAINT FK_BB662DEC9D1C3019 FOREIGN KEY (participant_id) REFERENCES sorties (id)');
        $this->addSql('ALTER TABLE sorties_participants ADD CONSTRAINT FK_BB662DEC838709D5 FOREIGN KEY (participants_id) REFERENCES participants (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281C49100234');
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281C8322D61A');
        $this->addSql('ALTER TABLE lieux DROP FOREIGN KEY FK_9E44A8AED3B6AC32');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_716970924FB3325D');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E849100234');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E84FB3325D');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E8DAD1DA15');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E822C8927D');
        $this->addSql('ALTER TABLE sorties_participants DROP FOREIGN KEY FK_BB662DEC9D1C3019');
        $this->addSql('ALTER TABLE sorties_participants DROP FOREIGN KEY FK_BB662DEC838709D5');
        $this->addSql('DROP TABLE etats');
        $this->addSql('DROP TABLE inscriptions');
        $this->addSql('DROP TABLE lieux');
        $this->addSql('DROP TABLE participants');
        $this->addSql('DROP TABLE sites');
        $this->addSql('DROP TABLE sorties');
        $this->addSql('DROP TABLE sorties_participants');
        $this->addSql('DROP TABLE villes');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
