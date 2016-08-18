<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

use AppBundle\Entity\UserWord;
use AppBundle\Form\UserWordType;

/**
 * HomeController
 */
class HomeController extends Controller
{
    /**
     * Displays home.
     *
     * @Route("/")
     */
    public function indexAction()
    {
        // Get entity manager
        $em = $this->getDoctrine()->getManager();

        // Retrieve UserWords
        $userwords = $em->getRepository('AppBundle:UserWord')->findAllQB();

        return $this->render('/home/index.html.twig', array(
            'userwords' => $userwords,
        ));
    }
}
