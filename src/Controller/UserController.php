<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/web/user/area/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        if($this->isGranted('ROLE_ADMIN')){
          return $this->render('user/index.html.twig', [
              'users' => $userRepository->findAll(),
          ]);
        } else {
          $user = $this->getUser();
          return $this->redirectToRoute('user_show', array('id'=>$user->getId()));
        }

    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            throw new \Exception('Invalid resource');
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user, array('needPassword'=>true));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles($form->get('roles')->getData());
            $user->setCreatedAt(new \DateTime());
            $user->setPassword(
               $passwordEncoder->encodePassword(
                   $user,
                   $form->get('plainPassword')->getData()
               )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            $currentUser = $this->getUser();
            if($user->getId() != $currentUser->getId())
              throw new \Exception('Invalid resource');
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = null;
        if(!$this->isGranted('ROLE_ADMIN')){
            $currentUser = $this->getUser();
            if($user->getId() != $currentUser->getId())
              throw new \Exception('Invalid resource');
            else {
              $form = $this->createForm(UserType::class, $user, array('needPassword'=>false, 'allowRol'=>false));
            }
        } else {
            $form = $this->createForm(UserType::class, $user);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(in_array("ROLE_ADMIN", $form->get('roles')->getData())){
                throw new \Exception('Invalid resource');
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            throw new \Exception('Invalid resource');
        }
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
