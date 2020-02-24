<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Festival;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('duree')
            ->add('date')
            //->add('created_at')
            ->add('categorie',EntityType::class,['class'=>Categorie::class,'mapped'=>false,'label'=>'Categorie : ','choice_label'=>'nom'])
            ->add('festival',EntityType::class,['class'=>Festival::class,'mapped'=>false,'label'=>'Festival : ','choice_label'=>'nom'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
