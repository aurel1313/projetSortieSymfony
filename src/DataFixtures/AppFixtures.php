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

        $site2 = new Sites();
        $site2->setNom('Poitiers');
        $manager->persist($site2);

        $site3 = new Sites();
        $site3->setNom('Paris');
        $manager->persist($site3);

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
        $participant1->setRoles(['ROLE_ADMIN']);
        $participant1->setActif(true);
        $participant1->setSiteIdsite($site);
        $manager->persist($participant1);

        $participant2 = new Participants();
        $participant2->setPseudo('coco79');
        $participant2->setNom('Cadu');
        $participant2->setPrenom('Corentin');
        $participant2->setTelephone('0624598724');
        $participant2->setEmail('corentin@cadu.fr');
        $participant2->setPassword(
            $this->userPasswordHasher->hashPassword(
                $participant2,
                'azerty'
            )
        );
        $participant2->setAdministrateur(false);
        $participant2->setActif(true);
        $participant2->setSiteIdsite($site2);
        $manager->persist($participant2);

        $participant3 = new Participants();
        $participant3->setPseudo('vic79');
        $participant3->setNom('Marsac');
        $participant3->setPrenom('Victore');
        $participant3->setTelephone('0624598724');
        $participant3->setEmail('victor@marsac.fr');
        $participant3->setPassword(
            $this->userPasswordHasher->hashPassword(
                $participant3,
                'azerty'
            )
        );
        $participant3->setAdministrateur(false);
        $participant3->setActif(true);
        $participant3->setSiteIdsite($site3);
        $manager->persist($participant3);

        $participant4 = new Participants();
        $participant4->setPseudo('test17');
        $participant4->setNom('Test');
        $participant4->setPrenom('Test');
        $participant4->setTelephone('0624598724');
        $participant4->setEmail('test@test.fr');
        $participant4->setPassword(
            $this->userPasswordHasher->hashPassword(
                $participant4,
                'azerty'
            )
        );
        $participant4->setAdministrateur(false);
        $participant4->setActif(true);
        $participant4->setSiteIdsite($site);
        $manager->persist($participant4);

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
        $sortie->setDateHeureDebut(new \DateTime('2023-10-10 10:00:00'));
        $sortie->setDuree(90);
        $sortie->setDateLimiteInscription(new \DateTime('2023-10-08'));
        $sortie->setMotifAnnulation('');
        $sortie->setNombreInscriptionMax(10);
        $sortie->setInfoSorties('Apéritif à 19h avec les amis. Thème de la soirée Octobre Rose !');
        $sortie->setPhotoSorties('https://www.lsa-conso.fr/mediatheque/1/8/3/000501381_896x598_c.jpg');
        $sortie->setSiteIdsite($site);
        $sortie->setLieuIdlieu($lieu);
        $sortie->setEtatIdetat($etat1);
        $sortie->setParticipantIdparticipant($participant1);
        $manager->persist($sortie);

        $sortie2 = new Sorties();
        $sortie2->setNom('test 1');
        $sortie2->setDateHeureDebut(new \DateTime('2023-10-18 15:00:00'));
        $sortie2->setDuree(240);
        $sortie2->setDateLimiteInscription(new \DateTime('2023-10-14'));
        $sortie2->setMotifAnnulation('');
        $sortie2->setNombreInscriptionMax(20);
        $sortie2->setInfoSorties('azerty');
        $sortie2->setPhotoSorties('https://www.lsa-conso.fr/mediatheque/1/8/3/000501381_896x598_c.jpg');
        $sortie2->setSiteIdsite($site);
        $sortie2->setLieuIdlieu($lieu);
        $sortie2->setEtatIdetat($etat2);
        $sortie2->setParticipantIdparticipant($participant1);
        $manager->persist($sortie2);

        $sortie3 = new Sorties();
        $sortie3->setNom('test 2');
        $sortie3->setDateHeureDebut(new \DateTime('2023-10-20 10:00:00'));
        $sortie3->setDuree(120);
        $sortie3->setDateLimiteInscription(new \DateTime('2023-10-18'));
        $sortie3->setMotifAnnulation('');
        $sortie3->setNombreInscriptionMax(100);
        $sortie3->setInfoSorties('azerty');
        $sortie3->setPhotoSorties('https://www.lsa-conso.fr/mediatheque/1/8/3/000501381_896x598_c.jpg');
        $sortie3->setSiteIdsite($site2);
        $sortie3->setLieuIdlieu($lieu);
        $sortie3->setEtatIdetat($etat7);
        $sortie3->setParticipantIdparticipant($participant1);
        $manager->persist($sortie3);

        $sortie4 = new Sorties();
        $sortie4->setNom('test 3');
        $sortie4->setDateHeureDebut(new \DateTime('2023-10-22 10:00:00'));
        $sortie4->setDuree(30);
        $sortie4->setDateLimiteInscription(new \DateTime('2023-10-20'));
        $sortie4->setMotifAnnulation('');
        $sortie4->setNombreInscriptionMax(50);
        $sortie4->setInfoSorties('azerty');
        $sortie4->setPhotoSorties('https://www.lsa-conso.fr/mediatheque/1/8/3/000501381_896x598_c.jpg');
        $sortie4->setSiteIdsite($site2);
        $sortie4->setLieuIdlieu($lieu);
        $sortie4->setEtatIdetat($etat7);
        $sortie4->setParticipantIdparticipant($participant2);
        $manager->persist($sortie4);

        $sortie5 = new Sorties();
        $sortie5->setNom('test 4');
        $sortie5->setDateHeureDebut(new \DateTime('2023-10-18 15:00:00'));
        $sortie5->setDuree(180);
        $sortie5->setDateLimiteInscription(new \DateTime('2023-10-14'));
        $sortie5->setMotifAnnulation('');
        $sortie5->setNombreInscriptionMax(10);
        $sortie5->setInfoSorties('azerty');
        $sortie5->setPhotoSorties('https://www.lsa-conso.fr/mediatheque/1/8/3/000501381_896x598_c.jpg');
        $sortie5->setSiteIdsite($site3);
        $sortie5->setLieuIdlieu($lieu);
        $sortie5->setEtatIdetat($etat2);
        $sortie5->setParticipantIdparticipant($participant2);
        $manager->persist($sortie5);

        $sortie6 = new Sorties();
        $sortie6->setNom('test 5');
        $sortie6->setDateHeureDebut(new \DateTime('2023-10-25 10:00:00'));
        $sortie6->setDuree(90);
        $sortie6->setDateLimiteInscription(new \DateTime('2023-10-20'));
        $sortie6->setMotifAnnulation('');
        $sortie6->setNombreInscriptionMax(15);
        $sortie6->setInfoSorties('azerty');
        $sortie6->setPhotoSorties('https://www.lsa-conso.fr/mediatheque/1/8/3/000501381_896x598_c.jpg');
        $sortie6->setSiteIdsite($site3);
        $sortie6->setLieuIdlieu($lieu);
        $sortie6->setEtatIdetat($etat2);
        $sortie6->setParticipantIdparticipant($participant3);
        $manager->persist($sortie6);

        $manager->flush();
    }
}
