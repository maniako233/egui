<?php

namespace App\Form;

use App\Entity\Avis;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvisformType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('message')
        // Cacher le champ date
       
        // Désactiver le champ user
        ->add('user', EntityType::class, [
            'class' => User::class,
            'choice_label' => 'id',
            'disabled' => true,
        ])
    ;
}

public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([
        'data_class' => Avis::class,
    ]);
}
}