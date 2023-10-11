<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Participants;
use App\Entity\Sites;
use App\Entity\Etats;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortiesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('date_heure_debut',DateTimeType::class,[
                'widget' =>'single_text'])
            ->add('duree')
            ->add('date_limite_inscription',DateTimeType::class,[
                'widget' =>'single_text'])
            ->add('nombre_inscription_max')
            ->add('info_sorties')
            ->add('motif_annulation')
            ->add('photo_sorties')
            ->add('participant_idparticipant_id', EntityType::class,[
                'class' => Participants::class,
                'mapped' => false,
                'choice_label' => 'pseudo'
            ])
            ->add('site_idsite', EntityType::class,[
                'class' => Sites::class,
                'mapped' => false,
                'choice_label' => 'nom'
            ])
            ->add('lieu_idlieu_id', EntityType::class,[
                'class' => Lieux::class,
                'mapped' => false,
                'choice_label' => 'nom'
            ])
            ->add('etat_idetat_id',EntityType::class,[
                'class' => Etats::class,
                'mapped' => false,
                'choice_label' => 'libelle'
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
