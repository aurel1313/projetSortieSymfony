<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Entity\Sites;
use App\Form\LieuxFormType;
use App\Repository\LieuxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/lieux', name: 'app_admin_lieux')]
class AdminLieuxController extends AbstractController
{
    #[Route('/', name: '_lister')]
    public function afficher(LieuxRepository $lieuxRepository): Response
    {
        $lieux = $lieuxRepository->findAll();
        return $this->render('admin_lieux/voir.html.twig', [
            'controller_name' => 'AdminLieuxController',
            'lieux' => $lieux
        ]);
    }
    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function index(Request $request, EntityManagerInterface $entityManager, LieuxRepository $lieuxRepository, int $id = null): Response
    {
        if($id == null){
            $lieux = new Lieux();
        }else{
            $lieux = $lieuxRepository->find($id);
        }

        $form = $this->createForm(LieuxFormType::class, $lieux);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lieux);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_lieux_lister');
        }

        return $this->render('admin_lieux/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function supprimer(Request $request, EntityManagerInterface $entityManager, LieuxRepository $lieuxRepository, int $id = null): Response
    {
        $lieux = $lieuxRepository->find($id);
        $entityManager->remove($lieux);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_lieux_lister');
    }
}
