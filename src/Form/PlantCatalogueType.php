<?php

namespace App\Form;

use App\Entity\PlantCatalogue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlantCatalogueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CategorieName')
            ->add('listeObjets')
            ->add('member', null, [
                'disabled' => true,
            ])
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlantCatalogue::class,
        ]);
    }
}
