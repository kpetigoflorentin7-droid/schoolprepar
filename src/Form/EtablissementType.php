<?php
namespace App\Form;

use App\Entity\Etablissement;
use App\Entity\Filiere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Url;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => "Nom de l'établissement",
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'Ex : Université de Lomé',
                ],
                'constraints' => [
                    new NotBlank(['message' => "Le nom de l'établissement est obligatoire"]),
                    new Length(['max' => 150]),
                ],
            ])
            ->add('adresse', TextType::class, [
                'label'    => 'Adresse',
                'required' => false,
                'attr'     => [
                    'class'       => 'form-control',
                    'placeholder' => 'Ex : Rue de l\'Université',
                ],
            ])
            ->add('ville', TextType::class, [
                'label'    => 'Ville',
                'required' => false,
                'attr'     => [
                    'class'       => 'form-control',
                    'placeholder' => 'Ex : Lomé',
                ],
            ])
            ->add('email', EmailType::class, [
                'label'    => 'Email de contact',
                'required' => false,
                'attr'     => [
                    'class'       => 'form-control',
                    'placeholder' => 'contact@etablissement.tg',
                ],
                'constraints' => [
                    new Email(['message' => "L'adresse e-mail '{{ value }}' est invalide"]),
                ],
            ])
            ->add('telephone', TextType::class, [
                'label'    => 'Téléphone',
                'required' => false,
                'attr'     => [
                    'class'       => 'form-control',
                    'placeholder' => 'Ex : +228 22 00 00 00',
                ],
                'constraints' => [
                    new Length(['max' => 20]),
                ],
            ])
            ->add('image', TextType::class, [
                'label'    => "URL de l'image",
                'required' => false,
                'attr'     => [
                    'class'       => 'form-control',
                    'placeholder' => 'https://exemple.com/ecole.jpg',
                ],
                'constraints' => [
                    new Length(['max' => 1000]),
                    new Url(['message' => 'Entrez une URL valide (ex: https://...)']),
                    new Regex([
                        'pattern' => '/^https?:\/\//i',
                        'message' => 'Utilisez une URL web (http/https)',
                    ]),
                ],
            ])
            ->add('filieres', EntityType::class, [
                'class'        => Filiere::class,
                'choice_label' => 'nom',
                'multiple'     => true,
                'expanded'     => false,
                'required'     => false,
                'label'        => 'Filières proposées',
                'attr'         => ['class' => 'form-control', 'size' => 5],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Etablissement::class]);
    }
}