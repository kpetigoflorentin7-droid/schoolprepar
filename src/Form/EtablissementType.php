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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Url;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',       TextType::class,  ['attr' => ['class' => 'form-control']])
            ->add('adresse',   TextType::class,  ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('ville',     TextType::class,  ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('email',     EmailType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('telephone', TextType::class,  ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('image', TextType::class, [
                'required' => false,
                'label' => "URL de l'image",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'https://exemple.com/ecole.jpg',
                ],
                'constraints' => [
                    new Length(max: 1000, maxMessage: "L'URL est trop longue (1000 caractères max)."),
                    new Url(message: "Entrez une URL valide (ex: https://...)."),
                    new Regex(
                        pattern: '/^https?:\/\//i',
                        message: "Utilisez une URL web (http/https), pas une image base64.",
                    ),
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