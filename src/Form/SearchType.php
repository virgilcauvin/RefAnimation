<?php

namespace App\Form;

use App\Entity\PublicCible;
use App\Entity\Langue;
use App\Entity\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('byText', TextType::class,[
                'required' => false,
                'label' => 'Recherche',
                'attr' => [
                    'placeholder' => 'Titre de film, réalisateur, prix reçus...'
                ]
            ])
            ->add('maxAnnee', IntegerType::class, [
                'required' => false,
                'label' => 'Année maximum',
            ])
            ->add('minAnnee', IntegerType::class, [
                'required' => false,
                'label' => 'Année minimum',
            ])
            ->add('byMinDuree', IntegerType::class,[
                'required' => false,
                'label' => 'Durée minimum',
            ])
            ->add('byMaxDuree', IntegerType::class,[
                'required' => false,
                'label' => 'Durée maximum',
            ])
            ->add('byTraduitFr', CheckboxType::class,[
                'required' => false,
                'label' => 'Traduit en francais'
            ])
            ->add('bySoustitresFr', CheckboxType::class,[
                'required' => false,
                'label' => 'Sous-titré en francais'
            ])
            ->add('byPublicCible', EntityType::class,[
                'class' => PublicCible::class,
                'choice_label' => 'nom',
                'required' => false,
                'label' => 'Public cible'
            ])
            ->add('byLangue', EntityType::class,[
                'class' => Langue::class,
                'choice_label' => 'nom',
                'required' => false,
                'label' => 'Langue'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix() {
        return '';
    }
}
