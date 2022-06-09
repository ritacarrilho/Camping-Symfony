<?php

namespace App\Form;

use App\Entity\RentalType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentalsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', null, 
            ['label' => 'Type'])
            ->add('capacity', null, 
            ['label' => 'Total Capacity'])
            ->add('dailyPrice')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RentalType::class,
        ]);
    }
}
