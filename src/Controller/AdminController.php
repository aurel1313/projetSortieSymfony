<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Form\ParticipantsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
Use App\Repository\ParticipantsRepository;
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(ParticipantsRepository $participantsRepository,Request $request , EntityManagerInterface $entityManager): Response
    {

            //$this->redirect("http://localhost:8000/_error/404");
        $participant = new Participants();

        $form = $this->createForm(ParticipantsType::class,$participant);

        $form->handleRequest($request);
         if($form->isSubmitted() && $form->isValid()){
             $participant =$form->getData();
            $entityManager->persist($participant);
            $entityManager->flush();
            $this->addFlash('success',"Inscription Validée");
            return $this->redirectToRoute('validationInscription');

         }

        return $this->render('admin/index.html.twig', [
            'form'=>$form,
        ]);
    }
    #[Route('/admin/inscrit', name: 'validationInscription')]

    public function isSubscribe(): Response{
      return $this->redirectToRoute('app_admin');
    }

}
