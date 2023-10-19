<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Form\ParticipantsType;
use App\Repository\ParticipantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfilController extends AbstractController
{

    #[Route('/profil/{id}', name: 'app_profil')]
    #[Route('/profil/modifier/{id}', name: 'app_profil_modifier')]


    public function index(Request $request,ParticipantsRepository $participantsRepository,EntityManagerInterface $entityManager,SluggerInterface $slugger): Response

    {
        $id =$request->get('id');
        $newFilename="";
        if($id){
            $participant = $participantsRepository->find($id);
          // dd($participant->getPhotoProfil());
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
            //photo profil//
            $photo = $form->get('photoProfil')->getData();
            if($photo){
                $fileName= pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($fileName);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();




                try {
                    $photo->move('photo_directory',$newFilename);
                }catch(FileException $fileException){
                    dd($fileException);
                }
                $participant->setPhotoProfil($newFilename);
            }

            $entityManager->persist($participant);
            $entityManager->flush();
        }

        return $this->render('profil/index.html.twig', [
            'formProfil'=>$form,
            'filename'=>$newFilename,
            'photo'=>$participant->getPhotoProfil()

        ]);
    }
}
