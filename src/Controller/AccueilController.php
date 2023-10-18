<?php

namespace App\Controller;

use App\Repository\ParticipantsRepository;
use App\Repository\SitesRepository;
use App\Repository\SortiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(
        Request $request,
        SortiesRepository $sortiesRepository,
        ParticipantsRepository $participantsRepository,
        SitesRepository $sitesRepository
    ): Response
    {

        $filterStatus = [
            "not-published" => "Non publié",
            "available" => "Disponible",
            "closed" => "Clôturé",
            "canceled" => "Annulé",
            "ongoing" => "En cours"
        ];

        $parameters = [
            // checkboxes
            'organizing' => $request->request->has('organizing'),
            'participating' => $request->request->has('participating'),
            'not-participating' => $request->request->has('not-participating'),
            'passed' => $request->request->has('passed'),
            // other filters
            'campus' => $request->request->has('campus') ? $request->request->get('campus') : null,
            'name' => $request->request->has('name') ? $request->request->get('name') : null,
            'dateStart' => $request->request->has('dateStart') ? $request->request->get('dateStart') : null,
            'dateEnd' => $request->request->has('dateEnd') ? $request->request->get('dateEnd') : null,
            'status' => $request->request->has('status') ? $request->request->get('status') : null
        ];
        $sorties = $sortiesRepository->findByFilters($parameters, $this->getUser() ?? null);
        $sites = $sitesRepository->findAll();
        $participant = $participantsRepository->findAll();

       return $this->render('accueil.html.twig',[
           'sortie'=>$sorties,
           'participants'=>$participant,
           'sites' => $sites,
           'filterStatus' => $filterStatus
       ]);

    }

}
