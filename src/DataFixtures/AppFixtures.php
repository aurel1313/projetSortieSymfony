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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher){
        $this->userPasswordHasher = $userPasswordHasher;
    }
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
        $participant1->setPassword(
            $this->userPasswordHasher->hashPassword(
                $participant1,
                'azerty'
            )
        );
        $participant1->setAdministrateur(true);
        $participant1->setActif(true);
        $participant1->setSiteIdsite($site);
        $manager->persist($participant1);

        $etat1 = new Etats();
        $etat1->setLibelle('En création');
        $manager->persist($etat1);
        $etat2 = new Etats();
        $etat2->setLibelle('Ouverte');
        $manager->persist($etat2);
        $etat3 = new Etats();
        $etat3->setLibelle('Clôturée');
        $manager->persist($etat3);
        $etat4 = new Etats();
        $etat4->setLibelle('Activité en cours');
        $manager->persist($etat4);
        $etat5 = new Etats();
        $etat5->setLibelle('Activité terminé');
        $manager->persist($etat5);
        $etat6 = new Etats();
        $etat6->setLibelle('Activité historisée');
        $manager->persist($etat6);
        $etat7 = new Etats();
        $etat7->setLibelle('Activité annulée');
        $manager->persist($etat7);

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
        $sortie->setEtatIdetat($etat1);
        $sortie->setParticipantIdparticipant($participant1);
        $manager->persist($sortie);

        $manager->flush();
    }
}
