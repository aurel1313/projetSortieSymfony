<?php

namespace App\Controller;

use App\Repository\ParticipantsRepository;
use App\Repository\SortiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(SortiesController $sortiesController,SortiesRepository $sortiesRepository,ParticipantsRepository $participantsRepository): Response
    {
        $sorties = $sortiesRepository->findAll();

        $participant = $participantsRepository->findAll();


       return $this->render('accueil.html.twig',[
           'sortie'=>$sorties,
           'participants'=>$participant
       ]);

    }

}
