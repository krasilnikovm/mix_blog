<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render(':default:index.html.twig');
    }

    /**
     * @Route("/signin", name="sign_in")
     */
    public function signInAction()
    {
        return $this->render(':default:signin.html.twig');
    }
}
