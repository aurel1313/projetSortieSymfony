<?php

namespace App\Controller;

use App\Entity\Villes;
use App\Form\VillesFormType;
use App\Repository\VillesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin_villes', name: 'app_admin_villes')]
class AdminVillesController extends AbstractController
{
    #[Route('/', name: '_lister')]
    public function afficher(VillesRepository $villesRepository): Response
    {
        $ville = $villesRepository->findAll();
        return $this->render('admin_villes/voir.html.twig', [
            'controller_name' => 'AdminVillesController',
            'villes' => $ville
        ]);
    }

    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function index(Request $request, EntityManagerInterface $entityManager, VillesRepository $villesRepository, int $id = null): Response
    {
        if($id == null){
            $villes = new Villes();
        }else{
            $villes = $villesRepository->find($id);
        }

        $form = $this->createForm(VillesFormType::class, $villes);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($villes);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_villes_lister');
        }

        return $this->render('admin_villes/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function supprimer(Request $request, EntityManagerInterface $entityManager, VillesRepository $villesRepository, int $id = null): Response
    {
        $villes = $villesRepository->find($id);
        $entityManager->remove($villes);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_villes_lister');
    }
}
