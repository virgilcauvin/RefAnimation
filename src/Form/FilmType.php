<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Langue;
use App\Entity\Festival;
use App\Entity\Categorie;
use App\Entity\PublicCible;
use App\Entity\EditionFestival;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('duree')
            ->add('date')
            ->add('realisateur')
            ->add('annee_de_production')
            ->add('duree_de_production')
            ->add('lien_video')
            ->add('traduit_fr')
            ->add('soustitres_fr')
            ->add('imageFile', FileType::class, ['required' => false])
            //->add('created_at')
            ->add('langues',EntityType::class,['class'=>Langue::class,'choice_label'=>'nom', 'multiple' => true, 'required' => false])
            ->add('public_cibles',EntityType::class,['class'=>PublicCible::class,'choice_label'=>'nom', 'multiple' => true, 'expanded' => true, 'required' => false])
            ->add('categories',EntityType::class,['class'=>Categorie::class,'choice_label'=>'nom', 'multiple' => true, 'required' => false])
            //->add('festivals',EntityType::class,['class'=>Festival::class,'choice_label'=>'nom', 'multiple' => true, 'required' => false])
            ->add('editionFestivals', EntityType::class,['class'=>EditionFestival::class,'choice_label' => 'nom', 'multiple' => true, 'required' => false])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
