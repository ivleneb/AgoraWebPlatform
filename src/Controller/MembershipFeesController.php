<?php

namespace App\Controller;

use App\Entity\MembershipFees;
use App\Entity\FeesValue;
use App\Form\MembershipFeesType;
use App\Repository\MembershipFeesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web/user/area/membership/fees")
 */
class MembershipFeesController extends AbstractController
{
    /**
     * @Route("/", name="membership_fees_index", methods={"GET"})
     */
    public function index(MembershipFeesRepository $membershipFeesRepository): Response
    {
        $results = null;
        if(!$this->isGranted('ROLE_ADMIN')){
            $user = $this->getUser();
            $results = $membershipFeesRepository->findBy(array('registeredBy'=>$user->getId()),array('id'=>'DESC'));
        } else {
            $results = $membershipFeesRepository->findAll();
        }
        return $this->render('membership_fees/index.html.twig', [
            'membership_fees' => $results,
        ]);
    }

    /**
     * @Route("/new", name="membership_fees_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            throw new \Exception('Invalid resource');
        }

        $feeValue = $this->getDoctrine()->getRepository(FeesValue::class)->findBy(array(),array('id'=>'DESC'),1,0)[0];
        $membershipFee = new MembershipFees();
        $form = $this->createForm(MembershipFeesType::class, $membershipFee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $membershipFee->setRegisterDate(new \DateTime());
            $membershipFee->setRegisteredBy($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($membershipFee);
            $entityManager->flush();

            return $this->redirectToRoute('membership_fees_index');
        }

        return $this->render('membership_fees/new.html.twig', [
            'membership_fee' => $membershipFee,
            'feeValue' => $feeValue->getAmount(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="membership_fees_show", methods={"GET"})
     */
    public function show(MembershipFees $membershipFee): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            $user = $this->getUser();
            if($membershipFee->getRegisteredBy()->getId() != $user->getId())
              throw new \Exception('Invalid resource');
        }

        return $this->render('membership_fees/show.html.twig', [
            'membership_fee' => $membershipFee,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="membership_fees_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MembershipFees $membershipFee): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            throw new \Exception('Invalid resource');
        }

        $form = $this->createForm(MembershipFeesType::class, $membershipFee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('membership_fees_index');
        }

        return $this->render('membership_fees/edit.html.twig', [
            'membership_fee' => $membershipFee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="membership_fees_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MembershipFees $membershipFee): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            throw new \Exception('Invalid resource');
        }

        if ($this->isCsrfTokenValid('delete'.$membershipFee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($membershipFee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('membership_fees_index');
    }
}
