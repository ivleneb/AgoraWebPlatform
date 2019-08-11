<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WebUserAreaController extends AbstractController
{
    /**
     * @Route("/web/user/area", name="web_user_area")
     */
    public function index()
    {
        $user = $this->getUser();
        return $this->render('web_user_area/index.html.twig', [
            'controller_name' => 'WebUserAreaController',
            'user' => $user,
        ]);
    }
}
