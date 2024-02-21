<?php

namespace App\Controller;
use App\Entity\Plant;
use App\Repository\PlantRepository;
use App\Repository\MemberRepository;
use App\Form\PlantType;
use App\Entity\PlantCatalogue;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attributes\IsGranted;

#[Route('/plant')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class PlantController extends AbstractController
{
    #[Route('/list', name: 'plant_list', methods: ['GET'])]
    public function listplants(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $plants = $entityManager->getRepository(Plant::class)->findAll();
        
        return $this->render('plant/index.html.twig', [
            'plants' => $plants,
        ]);
    }
   
   
   
    // #[Route('/plant', name: 'app_plant')]
    #[Route('/{id}', name: 'Plant_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Plant $plant ) : Response
    {


        return $this->render('plant/show.html.twig',
        [ 'plant' => $plant ]
        );
    }

    #[Route('/', name: 'plant_index', methods: ['GET'])]
    public function index(PlantRepository $plantRepository, MemberRepository $MemberRepository): Response
    {
      
        return $this->render('plant/index.html.twig', [
            'plants' => $plantRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_plant_new',methods: ['GET', 'POST'])]
    public function new(Request $request, PlantRepository $plantRepository, PlantCatalogue $plantcatalogue, ManagerRegistry $doctrine): Response
    {   $entityManager = $doctrine->getManager();
        $plant = new Plant();
        $plant->setCategorie($plantcatalogue);
        $form = $this->createForm(PlantType::class, $plant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($plant);
            $img = $form->get('img')->getData();
            dump($img);
            if ($img) {
                $plant->setImg($img);
            }
            $entityManager->flush();
             // Make sure message will be displayed after redirect
             $this->addFlash('message', 'bien ajouté');
             // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()

            return $this->redirectToRoute('plant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('plant/new.html.twig', [
            'plant' => $plant,
            'form' => $form,
            'plantcatalogue'=> $plantcatalogue,
          
            
        ]);
    }


}
