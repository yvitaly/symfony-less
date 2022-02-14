<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('saler')
            ->add('salesDate')
            ->add('isPaid')
            ->add('user',  EntityType::class, [
                'label'=>'User',
                'class'=>User::class,
                'choice_label'=>'email'
            ])
            ->add('save', SubmitType::class , array(
                'label'=>'Save'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
