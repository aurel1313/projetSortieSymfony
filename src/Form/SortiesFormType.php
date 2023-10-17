<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Participants;
use App\Entity\Sites;
use App\Entity\Etats;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortiesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('date_heure_debut', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('duree')
            ->add('date_limite_inscription', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('nombre_inscription_max')
            ->add('info_sorties')
            ->add('motif_annulation')
            ->add('photo_sorties')
            ->add('participant_idparticipant_id', EntityType::class,[
                'class' => Participants::class,
                'mapped' => false,
                'choice_label' => 'pseudo'
            ])

            ->add('site_idsite', EntityType::class, [
                'class' => Sites::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionnez un site',
                'required' => true,
            ])


            ->add('lieu_idlieu', EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionnez un lieu',
                'required' => true
            ])

            ->add('etat_idetat',EntityType::class,[
                'class' => Etats::class,
                'choice_label' => 'libelle',
                'placeholder' => 'Sélectionnez un lieu',
                'required' => true
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
