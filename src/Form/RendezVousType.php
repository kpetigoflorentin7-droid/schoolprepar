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

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateHeure', DateTimeType::class, [
                'widget' => 'single_text',
                'label'  => 'Date et heure',
                'attr'   => ['class' => 'form-control'],
            ])
            ->add('mode', ChoiceType::class, [
                'choices'  => ['Présentiel' => 'presentiel', 'Visioconférence' => 'visio', 'Téléphone' => 'telephone'],
                'required' => false,
                'attr'     => ['class' => 'form-control'],
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => ['En attente' => 'en_attente', 'Confirmé' => 'confirme', 'Annulé' => 'annule'],
                'attr'    => ['class' => 'form-control'],
            ])
            ->add('motif', TextareaType::class, [
                'required' => false,
                'attr'     => ['class' => 'form-control', 'rows' => 3],
            ])
            ->add('eleve', EntityType::class, [
                'class'         => Utilisateur::class,
                'choice_label'  => fn(Utilisateur $u) => $u->getPrenom().' '.$u->getNom(),
                'label'         => 'Élève',
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('u')->orderBy('u.nom'),
                'attr'          => ['class' => 'form-control'],
            ])
            ->add('conseiller', EntityType::class, [
                'class'         => Utilisateur::class,
                'choice_label'  => fn(Utilisateur $u) => $u->getPrenom().' '.$u->getNom(),
                'label'         => 'Conseiller',
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('u')->orderBy('u.nom'),
                'attr'          => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => RendezVous::class]);
    }
}