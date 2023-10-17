<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231017101710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sorties_participants (sorties_id INT NOT NULL, participants_id INT NOT NULL, INDEX IDX_BB662DEC15DFCFB2 (sorties_id), INDEX IDX_BB662DEC838709D5 (participants_id), PRIMARY KEY(sorties_id, participants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sorties_participants ADD CONSTRAINT FK_BB662DEC15DFCFB2 FOREIGN KEY (sorties_id) REFERENCES sorties (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sorties_participants ADD CONSTRAINT FK_BB662DEC838709D5 FOREIGN KEY (participants_id) REFERENCES participants (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sorties_participants DROP FOREIGN KEY FK_BB662DEC15DFCFB2');
        $this->addSql('ALTER TABLE sorties_participants DROP FOREIGN KEY FK_BB662DEC838709D5');
        $this->addSql('DROP TABLE sorties_participants');
    }
}
