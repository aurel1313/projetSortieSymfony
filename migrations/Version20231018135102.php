<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231018135102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sorties_participants (participant_id INT NOT NULL, participants_id INT NOT NULL, INDEX IDX_BB662DEC9D1C3019 (participant_id), INDEX IDX_BB662DEC838709D5 (participants_id), PRIMARY KEY(participant_id, participants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sorties_participants ADD CONSTRAINT FK_BB662DEC9D1C3019 FOREIGN KEY (participant_id) REFERENCES sorties (id)');
        $this->addSql('ALTER TABLE sorties_participants ADD CONSTRAINT FK_BB662DEC838709D5 FOREIGN KEY (participants_id) REFERENCES participants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etats CHANGE libelle libelle VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7169709286CC499D ON participants (pseudo)');
        $this->addSql('ALTER TABLE sorties CHANGE date_heure_debut date_heure_debut DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sorties_participants DROP FOREIGN KEY FK_BB662DEC9D1C3019');
        $this->addSql('ALTER TABLE sorties_participants DROP FOREIGN KEY FK_BB662DEC838709D5');
        $this->addSql('DROP TABLE sorties_participants');
        $this->addSql('ALTER TABLE etats CHANGE libelle libelle VARCHAR(8) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_7169709286CC499D ON participants');
        $this->addSql('ALTER TABLE sorties CHANGE date_heure_debut date_heure_debut DATE NOT NULL');
    }
}
