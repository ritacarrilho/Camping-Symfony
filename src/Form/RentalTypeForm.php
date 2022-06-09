<?php

namespace App\Form;

use App\Entity\Owners;
use App\Entity\Rentals;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\OwnersRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RentalTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('reference')
            ->add('picture')
            ->add('ownerId', EntityType::class, 
            [
                'label' => 'Owner\'s name',
                'query_builder' => function(OwnersRepository $ownerRepo) { 
                    return $ownerRepo->orderLabel();
                }

            ])
            ->add('typeId', RentalsType::class)
            ->add('submit', SubmitType::class, ['label' => 'Save' ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rentals::class,
        ]);
    }
}
