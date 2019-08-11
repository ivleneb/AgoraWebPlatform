<?php

namespace App\Form;

use App\Entity\MembershipFees;
use App\Entity\Member;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembershipFeesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('registerDate')
            ->add('month')
            ->add('year')
            ->add('member', EntityType::class, [
                'class' => Member::class,
                'choice_label' => 'dni',
            ])
            //->add('registeredBy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MembershipFees::class,
        ]);
    }
}
