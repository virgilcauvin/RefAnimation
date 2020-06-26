<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Selection;
use App\Entity\EditionFestival;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('editionFestivals', EntityType::class,['class' => EditionFestival::class, 'choice_label' => 'nom', 'required' => false])
            ->add('films',EntityType::class,['class'=>Film::class,'choice_label'=>'nom', 'multiple' => true, 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Selection::class,
        ]);
    }
}
