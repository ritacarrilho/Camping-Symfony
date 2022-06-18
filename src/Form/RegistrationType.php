<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Owners;
use App\Repository\OwnersRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('role')
            ->add('password', PasswordType::class)
            ->add('confirm_password', PasswordType::class)
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
