<?php

namespace App\Form;

use App\Entity\Owners;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OwnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('id')
            ->add('firstName')
            ->add('lastName')
            // ->add('address')
            // ->add('contractNumber', null, 
            //         ['label' => 'Contract Number'])
            // ->add('endDate', null, 
            // ['label' => 'Contract End Date'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Owners::class,
        ]);
    }
}
