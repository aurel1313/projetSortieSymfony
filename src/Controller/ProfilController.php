<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Form\ParticipantsType;
use App\Repository\ParticipantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil/{id}', name: 'app_profil')]
    #[Route('/profil/modifier/{id}', name: 'app_profil_modifier')]
    public function index(Request $request,ParticipantsRepository $participantsRepository,EntityManagerInterface $entityManager): Response
    {
        $id =$request->get('id');
        if($id){
            $participant = $participantsRepository->find($id);

        }
        $form= $this->createForm(ParticipantsType::class,$participant);
        $form->handleRequest($request);
        $modifierParticipant = $form->getData();

        if($form->isSubmitted() && $form->isValid()){

            $participant->setEmail($modifierParticipant->getEmail());
            $participant->setPseudo($modifierParticipant->getPseudo());
            $participant->setRoles($modifierParticipant->getRoles());
            $participant->setNom($modifierParticipant->getNom());
            $participant->setPrenom($modifierParticipant->getPrenom());
            $participant->setPassword($modifierParticipant->getPassword());
            $participant->setSiteIdsite($modifierParticipant->getSiteIdSite());



            $entityManager->persist($participant);

            $entityManager->flush();
        }
        return $this->render('profil/index.html.twig', [
            'formProfil'=>$form,
        ]);
    }
}
