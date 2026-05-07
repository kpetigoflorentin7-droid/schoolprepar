<?php
namespace App\Form;

use App\Entity\Etablissement;
use App\Entity\Evenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => "Titre de l'événement",
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'Ex : Webinaire Génie Logiciel',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le titre est obligatoire']),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label'    => 'Description',
                'required' => false,
                'attr'     => [
                    'class'       => 'form-control',
                    'rows'        => 3,
                    'placeholder' => 'Décrivez l\'événement...',
                ],
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'label'  => 'Date et heure',
                'attr'   => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'La date est obligatoire']),
                ],
            ])
            ->add('lieu', TextType::class, [
                'label'    => 'Lieu',
                'required' => false,
                'attr'     => [
                    'class'       => 'form-control',
                    'placeholder' => 'Ex : Salle A, Lomé ou Zoom',
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label'    => "Type d'événement",
                'required' => false,
                'choices'  => [
                    'Webinaire'   => 'webinaire',
                    'Conférence'  => 'conference',
                    'Atelier'     => 'atelier',
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('placesMax', IntegerType::class, [
                'label'    => 'Nombre de places maximum',
                'required' => false,
                'attr'     => [
                    'class'       => 'form-control',
                    'placeholder' => 'Ex : 50',
                ],
                'constraints' => [
                    new Positive(['message' => 'Le nombre de places doit être positif']),
                ],
            ])
            ->add('etablissement', EntityType::class, [
                'class'        => Etablissement::class,
                'choice_label' => 'nom',
                'label'        => 'Établissement organisateur',
                'attr'         => ['class' => 'form-control'],
                'constraints'  => [
                    new NotBlank(['message' => "L'établissement est obligatoire"]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Evenement::class]);
    }
}