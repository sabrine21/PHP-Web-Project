<?php

namespace App\Controller\Admin;

use App\Entity\PlantCatalogue;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
class PlantCatalogueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlantCatalogue::class;
    }

   
    public function configureFields(string $pageName): iterable
    {
        return [
            
            IdField::new('id')->hideOnForm(),
                          TextField::new("CategorieName"),
                          AssociationField::new('listeObjets')
                                  ->onlyOnDetail()
                                  ->setTemplatePath('admin/fields/plant_catalogue_plants.html.twig')

         
        ];
    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }
    
}