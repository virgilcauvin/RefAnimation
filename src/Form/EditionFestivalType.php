<?php

namespace App\Form;

use App\Entity\Festival;
use App\Entity\EditionFestival;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EditionFestivalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut')
            ->add('dateFin')
            ->add('NbJour')
            ->add('ville')
            ->add('pays')
            ->add('NbLieuProjection')
            ->add('festival',EntityType::class,['class'=>Festival::class,'choice_label'=>'nom'])
            ->add('imageFile', FileType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditionFestival::class,
        ]);
    }
}
