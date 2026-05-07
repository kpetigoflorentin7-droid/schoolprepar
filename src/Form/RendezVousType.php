<?php
namespace App\Form;

use App\Entity\RendezVous;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateHeure', DateTimeType::class, [
                'widget' => 'single_text',
                'label'  => 'Date et heure du rendez-vous',
                'attr'   => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'La date et heure sont obligatoires']),
                ],
            ])
            ->add('mode', ChoiceType::class, [
                'label'    => 'Mode de rendez-vous',
                'choices'  => [
                    'Présentiel'      => 'presentiel',
                    'Visioconférence' => 'visio',
                    'Téléphone'       => 'telephone',
                ],
                'required' => false,
                'attr'     => ['class' => 'form-control'],
            ])
            ->add('statut', ChoiceType::class, [
                'label'   => 'Statut',
                'choices' => [
                    'En attente' => 'en_attente',
                    'Confirmé'   => 'confirme',
                    'Annulé'     => 'annule',
                ],
                'attr'    => ['class' => 'form-control'],
            ])
            ->add('motif', TextareaType::class, [
                'label'    => 'Motif du rendez-vous',
                'required' => false,
                'attr'     => [
                    'class'       => 'form-control',
                    'rows'        => 3,
                    'placeholder' => 'Décrivez le motif du rendez-vous...',
                ],
            ])
            ->add('eleve', EntityType::class, [
                'class'         => Utilisateur::class,
                'choice_label'  => fn(Utilisateur $u) => $u->getPrenom().' '.$u->getNom(),
                'label'         => 'Élève',
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('u')->orderBy('u.nom'),
                'attr'          => ['class' => 'form-control'],
                'constraints'   => [
                    new NotBlank(['message' => "L'élève est obligatoire"]),
                ],
            ])
            ->add('conseiller', EntityType::class, [
                'class'         => Utilisateur::class,
                'choice_label'  => fn(Utilisateur $u) => $u->getPrenom().' '.$u->getNom(),
                'label'         => 'Conseiller',
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('u')->orderBy('u.nom'),
                'attr'          => ['class' => 'form-control'],
                'constraints'   => [
                    new NotBlank(['message' => 'Le conseiller est obligatoire']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => RendezVous::class]);
    }
}