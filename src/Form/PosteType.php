<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Poste;
use App\Entity\Technicien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PosteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            /* ->add('techniciens', EntityType::class,['class'=>Technicien::class, 'choice_label'=>'nom', 'multiple'=>true, 'required'=>false]) */
            ->add('film', EntityType::class,['class'=>Film::class, 'choice_label'=>'nom', 'required'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Poste::class,
        ]);
    }
}
