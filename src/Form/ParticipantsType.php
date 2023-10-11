<?php

namespace App\Form;

use App\Entity\Participants;
use App\Entity\Sites;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ParticipantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label'=>'Email: ',
                'constraints'=>[
                    new Email([
                        'message'=>'email "{{value}}" doit avoir un format valide'
                    ])

                ]
            ])
            //->add('roles')//
            ->add('password',PasswordType::class,[
                'label'=>'Mot de passe: ',
                'hash_property_path' => 'password',
                'mapped' => false,
                'constraints'=>[
                    new Length([
                        'min' => 8,
                        'max' => 20,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le mot de passe ne doit pas dépasser {{ limit }} caractères.',
                    ])
                ]
            ])
            ->add('pseudo', TextType::class,[
                'label'=>'Pseudo: ',
                'constraints'=>[

                ]
            ])
            ->add('nom',TextType::class,[
            'label'=>'Nom: ',
                ])
            ->add('prenom', TextType::class,[
                'label'=>'Prenom: ',
            ])
            ->add('telephone',TextType::class,[
                'label'=>'Téléphone: ',
                'constraints'=>[
                    new Regex([
                        'pattern' => '/^\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}$/',
                        'message' => 'Invalid phone number format',
                    ])
                ]
            ])
            ->add('administrateur', CheckboxType::class, [
                'label' => 'Administrateur: ',
                'required' => false,

            ])
            ->add('actif',CheckboxType::class,[
                'label'=>'Actif: ',
                 'required'=>false,
                'false_values' => [false]
            ])
            ->add('site_idsite',EntityType::class,[
                'label'=>'Site: ',
                'class' => Sites::class,
                'choice_label' => 'nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participants::class,
        ]);
    }
}
