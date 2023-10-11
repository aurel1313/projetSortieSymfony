<?php

namespace App\Controller;

use App\Entity\Sites;
use App\Form\SitesFormType;
use App\Repository\SitesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin_sites', name: 'app_admin_sites')]
class AdminSitesController extends AbstractController
{
    #[Route('/', name: '_lister')]
    public function afficher(SitesRepository $sitesRepository): Response
    {
        $sites = $sitesRepository->findAll();
        return $this->render('admin_sites/voir.html.twig', [
            'controller_name' => 'AdminSitesController',
            'sites' => $sites
        ]);
    }
    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function index(Request $request, EntityManagerInterface $entityManager, SitesRepository $sitesRepository, int $id = null): Response
    {
        if($id == null){
            $sites = new Sites();
        }else{
            $sites = $sitesRepository->find($id);
        }

        $form = $this->createForm(SitesFormType::class, $sites);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sites);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_sites_lister');
        }

        return $this->render('admin_sites/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function supprimer(Request $request, EntityManagerInterface $entityManager, SitesRepository $sitesRepository, int $id = null): Response
    {
        $sites = $sitesRepository->find($id);
        $entityManager->remove($sites);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_sites_lister');
    }
}
