<?php

namespace App\DataFixtures;

use App\Entity\Etats;
use App\Entity\Lieux;
use App\Entity\Participants;
use App\Entity\Sites;
use App\Entity\Sorties;
use App\Entity\Villes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $site = new Sites();
        $site->setNom('Niort');
        $manager->persist($site);

        $participant1 = new Participants();
        $participant1->setPseudo('titi');
        $participant1->setNom('Dupont');
        $participant1->setPrenom('Thierry');
        $participant1->setTelephone('0624598724');
        $participant1->setEmail('titi.dupont@gmail.com');
        $participant1->setPassword('PasHashe'); /* Pas encore terminé A FAIRE --> Corentin */
        $participant1->setAdministrateur(true);
        $participant1->setActif(true);
        $participant1->setSiteIdsite($site);
        $manager->persist($participant1);

        $etat = new Etats();
        $etat->setLibelle('Créée');
        $manager->persist($etat);

        $ville = new Villes();
        $ville->setNom('Niort');
        $ville->setCodePostal('79000');
        $manager->persist($ville);

        $lieu = new Lieux();
        $lieu->setNom('La Brèche');
        $lieu->setRue('Rue Victor Hugo');
        $lieu->setLatitude(46.323023);
        $lieu->setLongitude(-0.45823);
        $lieu->setVilleIdville($ville);
        $manager->persist($lieu);

        $sortie = new Sorties();
        $sortie->setNom('Apéro Coupains');
        $date = \DateTime::createFromFormat('d-m-Y H:i:s', '20-10-2023 19:00:00');
        $sortie->setDateHeureDebut($date);
        $sortie->setDuree(90);
        $sortie->setDateLimiteInscription($date);
        $sortie->setMotifAnnulation('');
        $sortie->setNombreInscriptionMax(10);
        $sortie->setInfoSorties('Apéritif à 19h avec les amis. Thème de la soirée Octobre Rose !');
        $sortie->setPhotoSorties('https://www.lsa-conso.fr/mediatheque/1/8/3/000501381_896x598_c.jpg');
        $sortie->setSiteIdsite($site);
        $sortie->setLieuIdlieu($lieu);
        $sortie->setEtatIdetat($etat);
        $sortie->setParticipantIdparticipant($participant1);
        $manager->persist($sortie);

        $manager->flush();
    }
}