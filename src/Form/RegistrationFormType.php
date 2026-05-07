<?php
namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de famille',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'Ex : KOFFIGAN',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le nom est obligatoire']),
                    new Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'Ex : Florentin',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le prénom est obligatoire']),
                ],
            ])
            ->add('telephone', TextType::class, [
                'label'    => 'Téléphone (optionnel)',
                'required' => false,
                'attr'     => [
                    'class'       => 'form-control',
                    'placeholder' => 'Ex : +228 90 00 00 00',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'attr'  => [
                    'class'       => 'form-control',
                    'placeholder' => 'exemple@mail.com',
                ],
                'constraints' => [
                    new NotBlank(['message' => "L'email est obligatoire"]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type'           => PasswordType::class,
                'mapped'         => false,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'attr'  => ['class' => 'form-control', 'placeholder' => 'Minimum 6 caractères'],
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                    'attr'  => ['class' => 'form-control', 'placeholder' => 'Répéter le mot de passe'],
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'constraints'     => [
                    new NotBlank(['message' => 'Le mot de passe est obligatoire']),
                    new Length([
                        'min'        => 6,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Utilisateur::class]);
    }
}