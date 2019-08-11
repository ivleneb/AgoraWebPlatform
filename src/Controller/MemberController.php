<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web/user/area/member")
 */
class MemberController extends AbstractController
{
    /**
     * @Route("/", name="member_index", methods={"GET"})
     */
    public function index(MemberRepository $memberRepository): Response
    {
        $results = null;
        if(!$this->isGranted('ROLE_ADMIN')){
            $user = $this->getUser();
            $results = $memberRepository->findBy(array('registeredBy'=>$user->getId()),array('id'=>'DESC'));
        } else {
            $results = $memberRepository->findAll();
        }

        return $this->render('member/index.html.twig', [
            'members' => $results,
        ]);
    }

    /**
     * @Route("/new", name="member_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $member = new Member();
        $form = null;
        if(!$this->isGranted('ROLE_ADMIN'))
          $form = $this->createForm(MemberType::class, $member, array('disableNonVirtualReg'=>true));
        else $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            if(!$this->isGranted('ROLE_ADMIN')){
              $member->setNonVirtualRegister(false);
            }
            $member->setRegisteredBy($user);
            $member->setRegisterDate(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($member);
            $entityManager->flush();

            return $this->redirectToRoute('member_index');
        }

        return $this->render('member/new.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_show", methods={"GET"})
     */
    public function show(Member $member): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            $user = $this->getUser();
            if($member->getRegisteredBy()->getId() != $user->getId())
              throw new \Exception('Invalid resource');
        }
        return $this->render('member/show.html.twig', [
            'member' => $member,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="member_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Member $member): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            throw new \Exception('Invalid resource');
        }

        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('member_index');
        }

        return $this->render('member/edit.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Member $member): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            throw new \Exception('Invalid resource');
        }

        if ($this->isCsrfTokenValid('delete'.$member->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($member);
            $entityManager->flush();
        }

        return $this->redirectToRoute('member_index');
    }
}
