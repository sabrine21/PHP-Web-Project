<?php

namespace App\Controller;
use App\Entity\PlantCatalogue;
use App\Form\PlantCatalogueType;
use App\Entity\Member;
use App\Entity\User;
use App\Repository\PlantCatalogueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attributes\IsGranted;


#[Route('/plant/catalogue')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class PlantCatalogueController extends AbstractController
{
    #[Route('/', name: 'home' , methods: ['GET'])]
    public function indexAction(PlantCatalogueRepository $PlantCatalogueRepository, Member $member):Response
    {    
        return $this->render('plant_catalogue/index.html.twig',
            [ 'plant_catalogues' => $PlantCatalogueRepository->findAll(),
            'member' => $member]
        );
       
    }
        
    #[Route('/{id}/edit', name: 'app_plant_catalogue_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PlantCatalogue $plantcatalogue, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlantCatalogueType::class, $plantcatalogue);
        $form->handleRequest($request);
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
         ($this->getUser()->getUsermember() == $plantcatalogue->getMember());
         if(! $hasAccess) {
         throw $this->createAccessDeniedException("You cannot edit another member's Plant Catalogue!");
          }
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('PlantCatalogue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('plant_catalogue/edit.html.twig', [
            'plantcatalogue' => $plantcatalogue,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}', name: 'app_plant_catalogue_delete', methods: ['POST'])]
    public function delete(Request $request, PlantCatalogue $plantcatalogue, EntityManagerInterface $entityManager): Response
    {


        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
         ($this->getUser()->getUsermember() == $plantcatalogue->getMember());
         if(! $hasAccess) {
         throw $this->createAccessDeniedException("You cannot delete another member's Plant Catalogue!");
          }


        if ($this->isCsrfTokenValid('delete'.$plantcatalogue->getId(), $request->request->get('_token'))) {
            $entityManager->remove($plantcatalogue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('PlantCatalogue_index', [], Response::HTTP_SEE_OTHER);
    }
   
    
    

     #[Route('/list', name: 'PlantCatalogue_list', methods: ['GET'])]
    
     #[Route('/index', name: 'PlantCatalogue_index', methods: ['GET'])]
    
        
     public function listAction(ManagerRegistry $doctrine, Member $member): Response
     {
             $entityManager= $doctrine->getManager();
             $plantcatalogue = $entityManager->getRepository(PlantCatalogue::class)->findAll();
             
             
             return $this->render('plant_catalogue/index.html.twig',
                     [ 'plant_catalogues' => $plantcatalogue,
                       'member' => $member]
                     );
     }



     #[Route('/new/{id}', name: 'app_plant_catalogue_new',methods: ['GET', 'POST'])]
     public function new(Request $request, PlantCatalogueRepository $plantcatalogueRepository, Member $member): Response
     {   
         $plantcatalogue = new PlantCatalogue();
         $plantcatalogue->setMember($member);
         $form = $this->createForm(PlantCatalogueType::class, $plantcatalogue);
         $form->handleRequest($request);
        
         $hasAccess = $this->isGranted('ROLE_ADMIN') ||
         ($this->getUser()->getUsermember() == $plantcatalogue->getMember());
         if(! $hasAccess) {
         throw $this->createAccessDeniedException("You cannot add a new catalalogue in another member's Plant Catalogue!");
          }


         if ($form->isSubmitted() && $form->isValid()) {
             $entityManager->persist($plantcatalogue);
             $entityManager->flush();
              // Make sure message will be displayed after redirect
              $this->addFlash('message', 'bien ajouté');
              // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
 
             return $this->redirectToRoute('PlantCatalogue_index', [], Response::HTTP_SEE_OTHER);
         }
         

         return $this->render('plant_catalogue/new.html.twig', [
             'plant_catalogue' => $plantcatalogue,
             'form' => $form,
             'member'=> $member,
           
             
         ]);
     }
 


/**
 * Show a PlantCatalogue
 *
 * @param Integer $id (note that the id must be an integer)
 */



#[Route('/plant/catalogue/{id}', name: 'PlantCatalogue_show', requirements: ['id' => '\d+'], methods: ['GET'])]
public function show(ManagerRegistry $doctrine, $id)
{
        $plantRepo = $doctrine->getRepository(PlantCatalogue::class);
        $plantcatalogue = $plantRepo->find($id);
        if (!$plantcatalogue) {
                throw $this->createNotFoundException('The catalogue does not exist');
        }

        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
       ($this->getUser()->getUsermember() == $plantcatalogue->getMember());
       if(! $hasAccess) {
       throw $this->createAccessDeniedException("You cannot access another member's Plant Catalogue!");
        }


        return $this->render('plant_catalogue/show.html.twig', [
            'plant_catalogue' => $plantcatalogue,
            
        ]);
}
}














