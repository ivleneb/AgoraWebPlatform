<?php

namespace App\Controller;

use App\Entity\FeesValue;
use App\Form\FeesValueType;
use App\Repository\FeesValueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web/user/area/fees/value")
 */
class FeesValueController extends AbstractController
{
    /**
     * @Route("/", name="fees_value_index", methods={"GET"})
     */
    public function index(FeesValueRepository $feesValueRepository): Response
    {
        return $this->render('fees_value/index.html.twig', [
            'fees_values' => $feesValueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="fees_value_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            throw new \Exception('Invalid resource');
        }
        $feesValue = new FeesValue();
        $form = $this->createForm(FeesValueType::class, $feesValue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($feesValue);
            $entityManager->flush();

            return $this->redirectToRoute('fees_value_index');
        }

        return $this->render('fees_value/new.html.twig', [
            'fees_value' => $feesValue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fees_value_show", methods={"GET"})
     */
    public function show(FeesValue $feesValue): Response
    {
        return $this->render('fees_value/show.html.twig', [
            'fees_value' => $feesValue,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fees_value_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FeesValue $feesValue): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            throw new \Exception('Invalid resource');
        }

        $form = $this->createForm(FeesValueType::class, $feesValue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fees_value_index');
        }

        return $this->render('fees_value/edit.html.twig', [
            'fees_value' => $feesValue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fees_value_delete", methods={"DELETE"})
     */
    public function delete(Request $request, FeesValue $feesValue): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            throw new \Exception('Invalid resource');
        }
        
        if ($this->isCsrfTokenValid('delete'.$feesValue->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($feesValue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fees_value_index');
    }
}
