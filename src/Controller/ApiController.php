<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MemberDonation;

class ApiController extends AbstractController
{
    /**
     * @Route("/user-area/lucky/number", name="app_lucky_number")
     */
    public function number()
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    /**
     * @Route("/api/v1/member/{dni}", methods={"GET", "OPTIONS"}, name="getMember")
     */
     public function getMemberAction($dni)
     {
       $em = $this->getDoctrine()->getManager();
       $dql = "SELECT m FROM App\Entity\Member m WHERE m.dni='".$dni."'";
       $member = $em->createQuery($dql)->getOneOrNullResult();

       $serializer = $this->get('serializer');
       $jsonContent = null;
       if ($member != null){
         $show_attrb = ['name', 'fatherLastname', 'motherLastname'];
         $jsonContent = $serializer->serialize($member, 'json', [ 'attributes' => $show_attrb ]);
       }else {
         $jsonContent = $serializer->serialize(['status' => 0], 'json');
       }
       $res = new Response($jsonContent);
       $res->headers->set('Access-Control-Allow-Origin', '*');
       return $res;
     }

     /**
      * @Route("/api/v1/donation/member", methods={"POST", "OPTIONS"}, name="newMemberDonation")
      */
      public function newMemberDonationAction(Request $request)
      {
        $content = "Hola";//$request->getContent();
        /*$em = $this->getDoctrine()->getManager();
        $dql = "SELECT m FROM App\Entity\Member m WHERE m.dni='".$dni."'";
        $member = $em->createQuery($dql)->getOneOrNullResult();



        $serializer = $this->get('serializer');
        $jsonContent = null;
        if ($member != null){
          $show_attrb = ['name', 'fatherLastname', 'motherLastname'];
          $jsonContent = $serializer->serialize($member, 'json', [ 'attributes' => $show_attrb ]);
        }else {
          $jsonContent = $serializer->serialize(['status' => 0], 'json');
        }
        $res = new Response($jsonContent);
        $res->headers->set('Access-Control-Allow-Origin', '*');
        return $res;*/
        $res = new Response($content);
        $res->headers->set('Access-Control-Allow-Origin', '*');
        return $res;
      }
}

?>
