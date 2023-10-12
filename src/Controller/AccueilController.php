<?php

namespace App\Controller;

use App\Repository\SortiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(SortiesController $sortiesController): Response
    {

        $response1= $this->forward('App\Controller\SortiesController::lister');
        $response2= $this->forward('App\Controller\SortiesController::lister');
        $combinedContent = $response1->getContent() . $response2->getContent();
        return new Response($combinedContent);

    }

}
