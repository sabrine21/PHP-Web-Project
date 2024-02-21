<?php

namespace App\DataFixtures;

use App\Entity\PlantCatalogue;
use App\Entity\Plant;
use App\Entity\Member;
use App\Entity\User;
use App\Entity\Galerie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;



class AppFixtures extends Fixture implements DependentFixtureInterface
{
    // defines reference names for instances of categorie
    private const categorie_1 = 'Plantes intérieur';
    private const categorie_2 = 'Plantes décoration';
    private const categorie_3 = 'Plantes extérieur';
    private const categorie_4 = 'Plantes médicales';

   
 
    private const categorie11 = 'Sofienne';
    private const categorie12= 'Salim';
 

    private static function MembersGenerator()
   {
    yield [self::categorie11, 'Ingenieur informatique', 'sofienne@gmail.com'];
    yield [self::categorie12, 'Technicien Supérieur', 'salim@gmail.com'];
   }


   private static function GalerieGenerator()
   {
       yield [self::categorie11, 'Galerie de Sofienne', true, 'Plantes intérieur'];
       yield [self::categorie12, 'Galerie de Salim', false, 'Plantes extérieur'];
       // Ajoutez d'autres données de galerie selon vos besoins
   }

    /**
     * Generates initialization data for categories : [title]
     * @return \\Generator
     */

    private static function categoriesGenerator()
    {
        yield [self::categorie11,self::categorie_1];
        yield [self::categorie11,self::categorie_2];
        yield [self::categorie12,self::categorie_3];
        yield [self::categorie12,self::categorie_4];
       
       
    }

   
    /**
     * Generates initialization data for film recommendations:
     *  [film_title, film_year, recommendation]
     * @return \\Generator
     */

    private static function PlantsGenerator()
    {
        yield [self::categorie_1, "Ficus benjamina (Ficus)","Appréciée pour ses feuilles vertes brillantes et sa capacité à purifier l'air","40Euro","Disponible","img1.png"];
        yield [self::categorie_1, "Rubber plant (Ficus elastica)","Feuilles larges et brillantes,","50Euro","Disponible","img2.png"];
        yield [self::categorie_2, "Orchidée (Phalaenopsis)","Magnifiques fleurs en forme de papillon","110Euro","Disponible","img3.png"];
        yield [self::categorie_2, "Bonsaï","Beauté esthétique et symbolise l'harmonie entre l'homme et la nature","75Euro","Disponible","img4.png"];
        yield [self::categorie_3, "Lavande (Lavandula)","Plante aromatique célèbre pour ses fleurs violettes parfumées","90Euro","Disponible","img5.png"];
        yield [self::categorie_4, "Aloe vera (Aloe barbadensis miller)","Contenant un gel rafraîchissant","120Euro","Disponible","img6.png"];

   
    }
   
    public function getDependencies()
    {
            return [
                    UserFixtures::class,
            ];
    }

    public function load(ObjectManager $manager)
    {
       

        $inventoryRepo = $manager->getRepository(Member::class);

        foreach (self::MembersGenerator() as [$nom, $description, $useremail]) {
            $member = new Member();
            if ($useremail) {
                $user = $manager->getRepository(User::class)->findOneBy(['email' => $useremail]);
                if ($user) {
                    $member->setMemberuser($user);
                }
            }
            $member->setNom($nom);
            $member->setDescription($description);
            $manager->persist($member);
            $manager->flush();
            $this->addReference($nom, $member);
        }
        
        
    
       
     

    // Loop through the categories and members to create references
   
            // Once the PlantCatalogue instance has been saved to DB
            // it has a valid Id generated by Doctrine, and can thus
            // be saved as a future reference
            //$this->addReference($CategorieName, $plantcatalogue);
       
        $inventoryRepo = $manager->getRepository(PlantCatalogue::class);
       
        foreach (self::categoriesGenerator() as [$MemberReference,$CategorieName] ) {
            $member = $this->getReference($MemberReference);
            $plantcatalogue = new PlantCatalogue();
            $plantcatalogue->setCategorieName($CategorieName);
            $member->addMemberCatalogue($plantcatalogue);
            $manager->persist($plantcatalogue);
            $manager->flush();

            
            $this->addReference($CategorieName, $plantcatalogue);
        }

        foreach (self::GalerieGenerator() as [$MemberReference, $description, $publiee, $CategorieName]) {
            // Récupérer l'instance One-side de PlantCatalogue à partir de son nom de référence
            $plantcatalogue = $this->getReference($CategorieName);

            // Récupérer l'instance One-side de Member à partir de son nom de référence
            $member = $this->getReference($MemberReference);

            // Créer une nouvelle instance de Galerie
            $galerie = new Galerie();
            $galerie->setDescription($description);
            $galerie->setPubliee($publiee);
            $galerie->setCreateur($member);
            $galerie->setPlantcatalogue($plantcatalogue);

            // Ajouter des objets de la galerie si nécessaire
           
            foreach ($plantcatalogue->getListeObjets() as $plant) {
                // Utilisez la méthode addGalerieObjet() pour ajouter des objets à la collection de la galerie
                $galerie->addGalerieObjet($plant);
            }
            // Enregistrez la galerie dans la base de données
            $manager->persist($galerie);
        }


        $manager->flush();
        
        foreach (self::PlantsGenerator() as [$plantcatalogueReference, $name, $description, $prix, $stock,$img])
        {
            // Retrieve the One-side instance of .....plantcatalogue... from its reference name
            $plantcatalogue = $this->getReference($plantcatalogueReference);
            $plant = new Plant();
            $plant->setPlantName($name);
            $plant->setDescription($description);
            $plant->setPrix($prix);
            $plant->setStock($stock);
            $plant->setImg($img);
            // Add the Many-side ..objet.. to its containing plantcatalogue
            $plantcatalogue->addListeObjet($plant);

            // Requir that the ORM\OneToMany attribute on plantcatalogue::plant has "cascade: ['persist']"
            $manager->persist($plant);
        }
        $manager->flush();
    }


  
}




