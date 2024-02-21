<?php
namespace App\Controller\Admin;



use App\Entity\Member;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class MemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Member::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new("Nom"),
            TextField::new("Description"),
            AssociationField::new('memberCatalogue', 'PlantCatalogue'),
            

         
        ];
    }
}
