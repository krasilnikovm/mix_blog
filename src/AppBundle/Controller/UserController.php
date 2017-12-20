<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends Controller
{
    /**
     * @Route("/user/{id}", name="profile")
     */
    public function profileAction($id)
    {
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($id);

        if(!$user) {
            throw $this->createNotFoundException("The user with id " . $id . "not found");
        }



        if($this->getUser()->getId() === $user->getId()) {
            return $this->redirectToRoute('fos_user_profile_show');
        }


        return $this->render(':user:profile.html.twig', ['user' => $user]);
      }

}