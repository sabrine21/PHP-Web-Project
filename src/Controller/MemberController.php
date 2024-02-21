<?php

namespace App\Controller;
use App\Entity\Member;
use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attributes\IsGranted;



#[Route('/member')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class MemberController extends AbstractController
{
    #[Route('/', name: 'app_member_index', methods: ['GET'])]
    public function index(MemberRepository $memberRepository): Response
    {
        return $this->render('member/index.html.twig', [
            'members' => $memberRepository->findAll(),
        ]);
    }


#[Route('//{id}', name: 'member_show', requirements: ['id' => '\d+'], methods: ['GET'])]
public function show(Member $member ) : Response
{
    return $this->render('member/show.html.twig',
    [ 'member' => $member ]
    );
}

}
