<?php

namespace App\Controller;

use App\Entity\Sorties;
use App\Form\SortiesFormType;
use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin_sorties', name: 'app_admin_sorties')]
class AdminSortiesController extends AbstractController
{
    #[Route('/', name: '_lister')]
    public function afficher(SortiesRepository $sortiesRepository): Response
    {
        $sorties = $sortiesRepository->findAll();
        return $this->render('admin_sorties/voir.html.twig', [
            'controller_name' => 'AdminSortiesController',
            'sorties' => $sorties
        ]);
    }
    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function index(Request $request, EntityManagerInterface $entityManager, SortiesRepository $sortiesRepository, int $id = null): Response
    {
        if($id == null){
            $sorties = new Sorties();
        }else{
            $sorties = $sortiesRepository->find($id);
        }

        $form = $this->createForm(SortiesFormType::class, $sorties);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sorties);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_sorties_lister');
        }

        return $this->render('admin_sorties/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function supprimer(Request $request, EntityManagerInterface $entityManager, SortiesRepository $sortiesRepository, int $id = null): Response
    {
        $sorties = $sortiesRepository->find($id);
        $entityManager->remove($sorties);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_sorties_lister');
    }
}
