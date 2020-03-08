<?php

namespace App\Form;

use App\Entity\Tache;
use App\Entity\Utilisateurs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class UpdateformType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'attr' => ["class" => "form-control"]
            ])
            ->add('etat',CheckboxType::class)
            ->add('deadline',DateType::class,[
                'attr' => ["class" => "form-control"]
            ])
            ->add('utilisateur',EntityType::class,[
                    'attr' => ["class" => "form-control"],
                    'class' => Utilisateurs::class,
                    'choice_label' => 'nom',
                ]
            )
            ->add('submit',SubmitType::class,[
                'attr' => ["class" => "btn btn-primary"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
