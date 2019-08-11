<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\SearchMember;
use App\Entity\Member;
use App\Entity\MembershipFees;
use App\Form\SearchMemberType;


class SearchController extends AbstractController
{
    /**
     * @Route("/")
     * @Route("/search", name="search")
     */
    public function index(Request $request)
    {
        $searchMember = new SearchMember();
        $form = $this->createForm(SearchMemberType::class, $searchMember);
        $form->handleRequest($request);
        $member = null;
        $lastDate = "";
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $searchMember = $form->getData();
            $repo = $this->getDoctrine()->getRepository(Member::class);
            if($searchMember->getType()){
              // DNI search
              $member = $repo->findOneBy(['dni' => $searchMember->getDni()]);
            } else {
              // Full name search
              $member = $repo->findOneBy(['name' => $searchMember->getName(),
                                          'fatherLastname' => $searchMember->getFatherLastname(),
                                          'motherLastname' => $searchMember->getMotherLastname()
                                        ]);
            }

            if(!$member){
              $this->addFlash('notFound', 'No se enctró ningún asociado.');
            } else {
              $this->addFlash('found', 'Se encontró a un asociado');
              $lastMembershipFees = $this->getDoctrine()->getRepository(MembershipFees::class)->findBy(array('member'=>$member->getId()),array('id'=>'DESC'),1,0)[0];
              if($lastMembershipFees){
                $lastDate = $lastMembershipFees->getYear().'-'.$lastMembershipFees->getMonth().'-01';
              }
            }
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
            'member' => $member,
            'lastDate' => $lastDate
        ]);
    }
}
