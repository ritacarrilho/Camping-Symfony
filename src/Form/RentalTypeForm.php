<?php

namespace App\Form;

use App\Entity\Owners;
use App\Entity\Rentals;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\OwnersRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\RentalTypeRepository;
use App\Entity\RentalType;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
                'label' => 'Partners\'s name',
                'query_builder' => function(OwnersRepository $ownerRepo) { 
                    return $ownerRepo->orderLabel();
                },
                'class' => Owners::class,
                'choice_label' => function(Owners $ownerRepo) { 
                    return $ownerRepo->getFullName();
                },
                'expanded' => false,
                'multiple' => false,
                'required' => true
            ])
            ->add('typeId', EntityType::class,
            [
                'label' => 'Type\'s label',
                'query_builder' => function(RentalTypeRepository $rentalTypeRepo) { 
                    return $rentalTypeRepo->orderLabel();
                },
                'class' => RentalType::class,
                'choice_label' => function(RentalType $rentalTypeRepo) { 
                    return $rentalTypeRepo->getLabelCapacity();
                },
                'expanded' => false,
                'multiple' => false,
                'required' => true
            ])
            // [
            //     'label' => 'Capacity',
            //     'query_builder' => function(RentalTypeRepository $rentalTypeRepo) { 
            //         return $rentalTypeRepo->orderCapacity();
            //     },
            //     'class' => RentalType::class,
            //     'choice_label' => function(RentalType $rentalTypeRepo) { 
            //         return $rentalTypeRepo->getLabelCapacity();
            //     },
            //     'expanded' => false,
            //     'multiple' => false,
            //     'required' => true
            // ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                // 'class' => 'btn btn-success btn-sm'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rentals::class,
        ]);
    }
}
