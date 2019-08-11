<?php

namespace App\Controller;

use App\Entity\MemberDonation;
use App\Form\MemberDonationType;
use App\Repository\MemberDonationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web/user/area/members/donation")
 */
class MemberDonationController extends AbstractController
{
    /**
     * @Route("/", name="member_donation_index", methods={"GET"})
     */
    public function index(MemberDonationRepository $memberDonationRepository): Response
    {
        $results = null;
        if(!$this->isGranted('ROLE_ADMIN')){
            $user = $this->getUser();
            $results = $memberDonationRepository->findBy(array('registeredBy'=>$user->getId()),array('id'=>'DESC'));
        } else {
            $results = $memberDonationRepository->findAll();
        }
        return $this->render('member_donation/index.html.twig', [
            'member_donations' => $results,
        ]);
    }

    /**
     * @Route("/new", name="member_donation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $memberDonation = new MemberDonation();
        $form = $this->createForm(MemberDonationType::class, $memberDonation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $memberDonation->setRegisteredBy($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($memberDonation);
            $entityManager->flush();

            return $this->redirectToRoute('member_donation_index');
        }

        return $this->render('member_donation/new.html.twig', [
            'member_donation' => $memberDonation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_donation_show", methods={"GET"})
     */
    public function show(MemberDonation $memberDonation): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            $user = $this->getUser();
            if($memberDonation->getRegisteredBy()->getId() != $user->getId())
              throw new \Exception('Invalid resource');
        }
        return $this->render('member_donation/show.html.twig', [
            'member_donation' => $memberDonation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="member_donation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MemberDonation $memberDonation): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            throw new \Exception('Invalid resource');
        }

        $form = $this->createForm(MemberDonationType::class, $memberDonation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('member_donation_index');
        }

        return $this->render('member_donation/edit.html.twig', [
            'member_donation' => $memberDonation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_donation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MemberDonation $memberDonation): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            throw new \Exception('Invalid resource');
        }

        if ($this->isCsrfTokenValid('delete'.$memberDonation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($memberDonation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('member_donation_index');
    }
}
