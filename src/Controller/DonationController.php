<?php

namespace App\Controller;

use App\Entity\Donation;
use App\Form\DonationType;
use App\Repository\DonationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web/user/area/donation")
 */
class DonationController extends AbstractController
{
    /**
     * @Route("/", name="donation_index", methods={"GET"})
     */
    public function index(DonationRepository $donationRepository): Response
    {
        $results = null;
        if(!$this->isGranted('ROLE_ADMIN')){
            $user = $this->getUser();
            $results = $donationRepository->findBy(array('registeredBy'=>$user->getId()),array('id'=>'DESC'));
        } else {
            $results = $donationRepository->findAll();
        }
        return $this->render('donation/index.html.twig', [
            'donations' => $results,
        ]);
    }

    /**
     * @Route("/new", name="donation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $donation = new Donation();
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $donation->setRegisteredBy($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($donation);
            $entityManager->flush();

            return $this->redirectToRoute('donation_index');
        }

        return $this->render('donation/new.html.twig', [
            'donation' => $donation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="donation_show", methods={"GET"})
     */
    public function show(Donation $donation): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            $user = $this->getUser();
            if($donation->getRegisteredBy()->getId() != $user->getId())
              throw new \Exception('Invalid resource');
        }
        return $this->render('donation/show.html.twig', [
            'donation' => $donation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="donation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Donation $donation): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            throw new \Exception('Invalid resource');
        }

        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('donation_index');
        }

        return $this->render('donation/edit.html.twig', [
            'donation' => $donation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="donation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Donation $donation): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            throw new \Exception('Invalid resource');
        }

        if ($this->isCsrfTokenValid('delete'.$donation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($donation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('donation_index');
    }
}
