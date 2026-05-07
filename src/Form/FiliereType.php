<?php
namespace App\Form;

use App\Entity\Filiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Url;

class FiliereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la filière',
                'attr'  => ['class' => 'form-control', 'placeholder' => 'Ex : Génie Logiciel'],
                'constraints' => [
                    new NotBlank(['message' => 'Le nom est obligatoire']),
                    new Length(['max' => 150]),
                ],
            ])
            ->add('domaine', TextType::class, [
                'label'    => 'Domaine',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'Ex : Informatique'],
            ])
            ->add('duree', IntegerType::class, [
                'label'    => 'Durée (années)',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'Ex : 3'],
                'constraints' => [
                    new Positive(['message' => 'La durée doit être un nombre positif']),
                ],
            ])
            ->add('image', TextType::class, [
                'required' => false,
                'label'    => "URL de l'image",
                'attr'     => ['class' => 'form-control', 'placeholder' => 'https://exemple.com/image.jpg'],
                'constraints' => [
                    new Length(['max' => 1000]),
                    new Url(['message' => 'Entrez une URL valide (ex: https://...)']),
                    new Regex(['pattern' => '/^https?:\/\//i', 'message' => 'Utilisez une URL http/https']),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label'    => 'Description',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Décrivez cette filière...'],
            ])
            ->add('conditionsAdmission', TextareaType::class, [
                'label'    => "Conditions d'admission",
                'required' => false,
                'attr'     => ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Bac, concours...'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Filiere::class]);
    }
}