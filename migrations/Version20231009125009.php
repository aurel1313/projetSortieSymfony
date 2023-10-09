<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231009125009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etats (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(8) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscriptions (id INT AUTO_INCREMENT NOT NULL, participant_idparticipant_id INT DEFAULT NULL, sortie_idsortie_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_74E0281C49100234 (participant_idparticipant_id), UNIQUE INDEX UNIQ_74E0281C8322D61A (sortie_idsortie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281C49100234 FOREIGN KEY (participant_idparticipant_id) REFERENCES participants (id)');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281C8322D61A FOREIGN KEY (sortie_idsortie_id) REFERENCES sorties (id)');
        $this->addSql('ALTER TABLE lieux ADD ville_idville_id INT NOT NULL');
        $this->addSql('ALTER TABLE lieux ADD CONSTRAINT FK_9E44A8AED3B6AC32 FOREIGN KEY (ville_idville_id) REFERENCES villes (id)');
        $this->addSql('CREATE INDEX IDX_9E44A8AED3B6AC32 ON lieux (ville_idville_id)');
        $this->addSql('ALTER TABLE participants ADD site_idsite_id INT NOT NULL');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_716970924FB3325D FOREIGN KEY (site_idsite_id) REFERENCES sites (id)');
        $this->addSql('CREATE INDEX IDX_716970924FB3325D ON participants (site_idsite_id)');
        $this->addSql('ALTER TABLE sorties ADD participant_idparticipant_id INT DEFAULT NULL, ADD site_idsite_id INT NOT NULL, ADD lieu_idlieu_id INT NOT NULL, ADD etat_idetat_id INT NOT NULL');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E849100234 FOREIGN KEY (participant_idparticipant_id) REFERENCES participants (id)');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E84FB3325D FOREIGN KEY (site_idsite_id) REFERENCES sites (id)');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E8DAD1DA15 FOREIGN KEY (lieu_idlieu_id) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E822C8927D FOREIGN KEY (etat_idetat_id) REFERENCES etats (id)');
        $this->addSql('CREATE INDEX IDX_488163E849100234 ON sorties (participant_idparticipant_id)');
        $this->addSql('CREATE INDEX IDX_488163E84FB3325D ON sorties (site_idsite_id)');
        $this->addSql('CREATE INDEX IDX_488163E8DAD1DA15 ON sorties (lieu_idlieu_id)');
        $this->addSql('CREATE INDEX IDX_488163E822C8927D ON sorties (etat_idetat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E822C8927D');
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281C49100234');
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281C8322D61A');
        $this->addSql('DROP TABLE etats');
        $this->addSql('DROP TABLE inscriptions');
        $this->addSql('ALTER TABLE lieux DROP FOREIGN KEY FK_9E44A8AED3B6AC32');
        $this->addSql('DROP INDEX IDX_9E44A8AED3B6AC32 ON lieux');
        $this->addSql('ALTER TABLE lieux DROP ville_idville_id');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_716970924FB3325D');
        $this->addSql('DROP INDEX IDX_716970924FB3325D ON participants');
        $this->addSql('ALTER TABLE participants DROP site_idsite_id');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E849100234');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E84FB3325D');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E8DAD1DA15');
        $this->addSql('DROP INDEX IDX_488163E849100234 ON sorties');
        $this->addSql('DROP INDEX IDX_488163E84FB3325D ON sorties');
        $this->addSql('DROP INDEX IDX_488163E8DAD1DA15 ON sorties');
        $this->addSql('DROP INDEX IDX_488163E822C8927D ON sorties');
        $this->addSql('ALTER TABLE sorties DROP participant_idparticipant_id, DROP site_idsite_id, DROP lieu_idlieu_id, DROP etat_idetat_id');
    }
}
