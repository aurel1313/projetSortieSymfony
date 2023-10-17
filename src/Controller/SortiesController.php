<?php

namespace App\Controller;

use App\Entity\Etats;
use App\Repository\ParticipantsRepository;
use App\Repository\SortiesRepository;
use App\Entity\Sorties;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SortiesFormType;



#[Route('/sorties', name: 'app_sorties')]
class SortiesController extends AbstractController
{
    #[Route('/', name: 'lister')]
    public function lister(SortiesRepository $sortiesRepository): Response
    {

        return $this->render('sorties/index.html.twig',[
            'sorties' => $sortiesRepository->findBy([
            ])
        ]);

    }

    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request $request,
                           EntityManagerInterface $entityManager,
                           SortiesRepository $sortiesRepository,
                           int $id = null): Response
    {
        if($id == null) {
            $sorties = new Sorties();
        }else{
            $sorties = $sortiesRepository->find($id);

        }

        $form = $this->createForm(SortiesFormType::class,$sorties);

        $form->handleRequest($request);

        // si le form est soumis et est valide
        if($form->isSubmitted() && $form->isValid()){

            // traitement des données
            $entityManager->persist($sorties);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Le sorties a été ' . ($id == null ? 'ajouté' : 'modifié') . ' !'
            );

            return $this->redirectToRoute('app_sorties_lister');

        }

        return $this->render('/sorties/editer_sorties.html.twig',[
            'form' => $form,
            'sorties' => $sorties
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function supprimer(EntityManagerInterface $entityManager,
                              SortiesRepository $sortiesRepository,
                              int $id) : Response
    {

        $sorties = $sortiesRepository->find($id);
        $entityManager->remove($sorties);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Le sorties a été supprimé !'
        );

        return $this->redirectToRoute('app_sorties_lister');
    }



    #[Route('/inscrire/{id}', name: '_inscrire')]
    public function inscription(EntityManagerInterface $entityManager, SortiesRepository $sortieRepository, ParticipantsRepository $participantRepository, int $id = null): Response
    {

        if ($id !== null) {
            $sortie = $sortieRepository->find($id);
            $userco = $this->getUser();

            if ($userco !== null  && $sortie->getDateLimiteInscription() >= date("Y-m-d"))
            {
                $sortie->addParticipant($userco);

//                dd($sortie, $userco);
                $entityManager->persist($sortie);
                $entityManager->flush();
            }
            else
            {
                $this->addFlash(
                    'error',
                    "Il n'y a plus de place disponible ou la date limite d'inscription est dépassée."
                );
                return $this->redirectToRoute('app_sorties_lister');
            }

            if ($userco !== null && $sortie->getDateLimiteInscription() < date("Y-m-d"))
            {
                //CHANGER L'ETAT DE LA SORTIE
            }

            $this->addFlash(
                'success',
                'Vous êtes bien inscrit à la sortie !'
            );
        }

        return $this->redirectToRoute('app_sorties_lister');
    }



    #[Route('/desinscrire/{id}', name: '_desinscrire')]
    public function desinscrire(EntityManagerInterface $entityManager, SortiesRepository $sortieRepository, int $id = null): Response
    {
//        if ($id !== null) {
//            $sortie = $sortieRepository->find($id);
//            $userco = $this->getUser();
//
//            if ($userco !== null && $sortie !== null) {
//                // Récupérer la liste des participants
//                $participants = $sortie->getParticipants();
//
//                if ($participants !== null && $participants->contains($userco)) {
//                    // Supprimer l'utilisateur de la liste des participants
//                    $participants->removeElement($userco);
//                    $entityManager->persist($sortie);
//                    $entityManager->flush();
//
//                    $this->addFlash(
//                        'success',
//                        'Vous êtes désinscrit de la sortie !'
//                    );
//                } else {
//                    $this->addFlash(
//                        'error',
//                        "Vous n'êtes pas inscrit à cette sortie."
//                    );
//                }
//            }
//        }
//
        return $this->redirectToRoute('app_sorties_lister');
    }




}
