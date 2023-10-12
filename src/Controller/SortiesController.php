<?php

namespace App\Controller;

use App\Entity\Sorties;
use App\Controller\SortiesController;
use App\Repository\ParticipantsRepository;
use App\Repository\SortiesRepository;
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
}
