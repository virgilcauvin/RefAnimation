<?php

namespace App\Form;

use App\Entity\EditionFestival;
use App\Entity\Film;
use App\Entity\Prix;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrixType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('editionFestival', EntityType::class,['class' => EditionFestival::class, 'choice_label' => 'nom', 'required' => false])
            ->add('film', EntityType::class,['class'=>Film::class, 'choice_label' => 'nom', 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prix::class,
        ]);
    }
}
