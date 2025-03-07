<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Studio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class StudioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('lien')
            ->add('type')
            ->add('imageFile', FileType::class, ['required' => false])
            ->add('films', EntityType::class,['class'=>Film::class, 'choice_label'=>'nom', 'multiple'=>true, 'required'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Studio::class,
        ]);
    }
}
