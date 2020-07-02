<?php

namespace App\Form;

use App\Entity\Poste;
use App\Entity\Studio;
use App\Entity\Technicien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnicienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('adresse')
            ->add('mail')
            ->add('telephone')
            ->add('pays')
            ->add('studios', EntityType::class,['class'=>Studio::class, 'choice_label'=>'nom', 'multiple'=>true, 'required'=>false])
            ->add('postes', EntityType::class,['class'=>Poste::class, 'choice_label'=> function($poste) {
                    return $poste->getNom() . " - " . $poste->getFilm()->getNom();
                },
                'multiple'=>true, 'required'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Technicien::class,
        ]);
    }
}
