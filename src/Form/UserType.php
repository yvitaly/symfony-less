<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            //->add('roles')
            ->add('roles', ChoiceType::class, array(
                    'attr'  =>  array('class' => 'form-control',
                        'style' => 'margin:5px 0;'),
                    'choices' =>
                        array
                        (
                            'ROLE' => array
                            (
                                'admin' => 'ROLE_ADMIN',
                                'manager' => 'ROLE_MANAGER',
                                'salesman' => 'ROLE_SALESMAN',
                                'customer' => 'ROLE_CUSTOMER',
                            )
                        )
                ,
                    'multiple' => true,
                    'required' => true,
                )
            )
            ->add('password')
            ->add('firsName')
            ->add('lastName')
            ->add('save', SubmitType::class , array(
                'label'=>'Save'
            ))
            //->add('orders')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
