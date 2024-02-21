<?php

namespace App\Controller;

use App\Entity\Galerie;
use App\Entity\Plant;
use App\Entity\Member;
use App\Form\Galerie3Type;
use App\Repository\GalerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

#[Route('/galerie')]

class GalerieController extends AbstractController
{
    #[Route('/', name: 'app_galerie_index', methods: ['GET'])]
    public function index(GalerieRepository $galerieRepository, Member $member): Response
    {
        return $this->render('galerie/index.html.twig', [
            'galeries' => $galerieRepository->findAll(),
            'member' => $member,



        ]);
    }


    #[Route('/new', name: 'app_galerie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GalerieRepository $galerieRepository, Member $member): Response
    {   
        $member = $this->getUser();
        
        $galerie = new Galerie();
       
        $form = $this->createForm(Galerie3Type::class, $galerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($galerie);
            $entityManager->flush();
             // Make sure message will be displayed after redirect
             $this->addFlash('message', 'bien ajouté');
             // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()

            return $this->redirectToRoute('app_galerie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('galerie/new.html.twig', [
            'galerie' => $galerie,
            'form' => $form,
            
        ]);
    }

    #[Route('/{id}', name: 'app_galerie_show', methods: ['GET'])]
    public function show(Galerie $galerie, GalerieRepository $galerieRepository): Response
    {

        $hasAccess = false;
        if($this->isGranted('ROLE_ADMIN') || $galerie->isPubliee()) {
                $hasAccess = true;
        }
        else {
                $privateGaleries = array();
                $user = $this->getUser();
                if($user) {
                        $member = $user->getUsermember();
                        $privateGaleries = $galerieRepository->findBy(
                                [
                                      'Publiee' => false,
                                      'createur' => $member
                                ]);
                }
        }
        if(! $hasAccess) {
                throw $this->createAccessDeniedException("You cannot access the requested resource!");
        }

        return $this->render('galerie/show.html.twig', [
            'galerie' => $galerie,
            
        ]);
    }

    #[Route('/{id}/edit', name: 'app_galerie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Galerie $galerie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Galerie3Type::class, $galerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_galerie_index', [], Response::HTTP_SEE_OTHER);
        }

        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
        ($this->getUser()->getUsermember() == $galerie->getCreateur());
        if(! $hasAccess) {
        throw $this->createAccessDeniedException("You cannot edit another member's Galerie!");
         }

        return $this->render('galerie/edit.html.twig', [
            'galerie' => $galerie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_galerie_delete', methods: ['POST'])]
    public function delete(Request $request, Galerie $galerie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$galerie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($galerie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_galerie_index', [], Response::HTTP_SEE_OTHER);
    }


  

#[Route('/{galerie_id}/plant/{plant_id}', name: 'app_galerie_plant_show', methods: ['GET'])]
public function PlantShow(Galerie $galerie, Plant $plant): Response
{
    if(! $galerie->getPlant()->contains($objet)) {
        throw $this->createNotFoundException("Couldn't find such a plant in this galerie!");
}

$hasAccess = false;
if($this->isGranted('ROLE_ADMIN') || $galerie->isPublished()) {
        $hasAccess = true;
}
else {
        $user = $this->getUser();
          if( $user ) {
                  $member = $user->getMember();
                  if ( $member &&  ($member == $galerie->getCreator()) ) {
                          $hasAccess = true;
                  }
          }
}
if(! $hasAccess) {
        throw $this->createAccessDeniedException("You cannot access the requested ressource!");
}



    return $this->render('galerie/plant_show.html.twig', [
        'plant' => $plant,
        'galerie' => $galerie,
        ]);
}
}
