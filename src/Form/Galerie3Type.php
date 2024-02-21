<?php

namespace App\Form;

use App\Entity\Galerie;
use App\Repository\PlantRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Galerie3Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
        {
                //dump($options);
                $galerie = $options['data'] ?? null;
                $member = $galerie->getCreateur();

                $builder
                        ->add('description')
                        ->add('publiee')
                        ->add('plantcatalogue')
                        ->add('createur', null, [
                                'disabled'   => true,
                        ])
                        ->add('galerie_objet', null, [
                                'query_builder' => function (PlantRepository $er) use ($member) {
                                                return $er->createQueryBuilder('o')
                                                ->leftJoin('o.categorie', 'i')
                                                ->andWhere('i.member = :member')
                                                ->setParameter('member', $member)
                                                ;
                                        }
                                ])
                ;
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Galerie::class,
        ]);
    }
}
