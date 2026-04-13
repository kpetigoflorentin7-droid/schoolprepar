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
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Url;

class FiliereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',    TextType::class,    ['attr' => ['class' => 'form-control']])
            ->add('domaine',TextType::class,    ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('duree',  IntegerType::class, ['required' => false, 'label' => 'Durée (années)', 'attr' => ['class' => 'form-control']])
            ->add('image', TextType::class, [
                'required' => false,
                'label' => "URL de l'image",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'https://exemple.com/image.jpg',
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
            ->add('description', TextareaType::class, ['required' => false, 'attr' => ['class' => 'form-control', 'rows' => 4]])
            ->add('conditionsAdmission', TextareaType::class, [
                'label'    => "Conditions d'admission",
                'required' => false,
                'attr'     => ['class' => 'form-control', 'rows' => 3],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Filiere::class]);
    }
}