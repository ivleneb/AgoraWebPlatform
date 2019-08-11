<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('fatherLastname')
            ->add('motherLastname')
            ->add('birthdate')
            ->add('address')
            ->add('district')
            ->add('province')
            ->add('region')
            ->add('degreeOfInstruction')
            ->add('civilStatus')
            ->add('dni')
            ->add('cellphoneNumber')
            ->add('nonVirtualRegister',  CheckboxType::class, [
              'disabled' => $options['disableNonVirtualReg'],
            ])
            //->add('registerDate')
            //->add('registeredBy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
            'disableNonVirtualReg' => false,
        ]);
    }
}
