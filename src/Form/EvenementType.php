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

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',  TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('description', TextareaType::class, ['required' => false, 'attr' => ['class' => 'form-control', 'rows' => 3]])
            ->add('date',   DateTimeType::class, ['widget' => 'single_text', 'attr' => ['class' => 'form-control']])
            ->add('lieu',   TextType::class,  ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('type',   ChoiceType::class, [
                'required' => false,
                'choices'  => ['Webinaire' => 'webinaire', 'Conférence' => 'conference', 'Atelier' => 'atelier'],
                'attr'     => ['class' => 'form-control'],
            ])
            ->add('placesMax', IntegerType::class, ['required' => false, 'label' => 'Places max', 'attr' => ['class' => 'form-control']])
            ->add('etablissement', EntityType::class, [
                'class'        => Etablissement::class,
                'choice_label' => 'nom',
                'attr'         => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Evenement::class]);
    }
}