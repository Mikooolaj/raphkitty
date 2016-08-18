<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserWordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user', EntityType::class, array(
                    'class' => 'AppBundle:User',
                    'choice_label' => 'name',
                ))
                ->add('word', EntityType::class, array(
                    'class' => 'AppBundle:Word',
                    'choice_label' => 'name',
                ))
                ->add('submit', SubmitType::class, array(
                    'label' => 'Sauvegarder'
                ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\UserWord',
        ));
    }

    public function getName()
    {
        return 'userword';
    }
}
