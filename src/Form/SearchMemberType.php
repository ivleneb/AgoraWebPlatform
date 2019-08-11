<?php
// src/Form/TaskType.php
namespace App\Form;

use App\Entity\SearchMember;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchMemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class,[
                  'label' => 'Búsqueda por',
                  'expanded'=> true,
                  'multiple'=> false,
                  'choices' => [
                    'DNI' => true,
                    'Nombre Completo' => false,
                  ]
            ])
            ->add('dni', TextType::class, [
                  'label'  => 'DNI',
                  'required' => false
              ])
            ->add('name', TextType::class, [
                  'label'  => 'Nombre',
                  'required' => false
              ])
            ->add('fatherLastname', TextType::class, [
                  'label'  => 'Apellido Paterno',
                  'required' => false
              ])
            ->add('motherLastname', TextType::class, [
                  'label'  => 'Apellido Materno',
                  'required' => false
              ])
            ->add('Buscar', SubmitType::class)
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchMember::class,
        ]);
    }
}
