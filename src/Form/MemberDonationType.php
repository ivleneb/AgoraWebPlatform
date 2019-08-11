<?php

namespace App\Form;

use App\Entity\MemberDonation;
use App\Entity\Member;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberDonationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount')
            ->add('description')
            ->add('registerDate')
            ->add('member', EntityType::class, [
                'class' => Member::class,
                'choice_label' => 'dni',
            ])
            /*->add('registeredBy', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'dni',
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MemberDonation::class,
        ]);
    }
}
