<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminLieuxController extends AbstractController
{
    #[Route('/admin/lieux', name: 'app_admin_lieux')]
    public function index(): Response
    {
        return $this->render('admin_lieux/index.html.twig', [
            'controller_name' => 'AdminLieuxController',
        ]);
    }
}
