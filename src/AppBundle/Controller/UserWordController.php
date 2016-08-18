<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

use AppBundle\Entity\UserWord;

/**
 * UserWordController
 */
class UserWordController extends Controller
{
    /**
     * Lists all UserWords.
     *
     * @Route("/userword")
     */
    public function indexAction()
    {
        // Get entity manager
        $em = $this->getDoctrine()->getManager();

        // Retrieve UserWords
        $userwords = $em->getRepository('AppBundle:UserWord')->findAllQB();

        return $this->render('/userword/index.html.twig', array(
            'userwords' => $userwords,
        ));
    }

    /**
     * Displays a form to create a new UserWord.
     *
     * @Route("/userword/new")
     */
    public function newAction()
    {
        // Get request and entity manager
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        // Create UserWord form
        $userword = new UserWord();
        $form = $this->createForm('AppBundle\Form\UserWordType', $userword);

        // Process the form
        if ($this->process($form, $request, $em)) {
            return $this->redirect($this->generateUrl('app_userword_edit', array('id' => $userword->getId())));
        }

        return $this->render('/userword/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing UserWord.
     *
     * @Route("/userword/edit/{id}", requirements={"id": "\d+"})
     *
     * @param UserWord $userword
     */
    public function editAction(UserWord $userword)
    {
        // Get request and entity manager
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        // Create UserWord form
        $form = $this->createForm('AppBundle\Form\UserWordType', $userword);

        // Process the form
        if ($this->process($form, $request, $em)) {
            return $this->redirect($this->generateUrl('app_userword_edit', array('id' => $userword->getId())));
        }

        return $this->render('/userword/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a UserWord.
     *
     * @Route("/userword/delete/{id}", requirements={"id": "\d+"})
     *
     * @param UserWord $userword
     */
    public function deleteAction(UserWord $userword)
    {
        // Get entity manager
        $em = $this->getDoctrine()->getManager();

        // Remove and flush
        $em->remove($userword);
        $em->flush();

        return $this->redirect($this->generateUrl('app_userword_index'));
    }

    /**
     * Creates/Updates a UserWord.
     *
     * @param Form $form
     * @param Request $request
     * @param EntityManager $em
     */
    public function process(Form $form, Request $request, EntityManager $em)
    {
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                // Persist and flush
                $em->persist($form->getData());
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice', 'Les modifications ont bien été enregistrées.');

                return true;
            }

            $this->get('session')->getFlashBag()->add('error', "Le formulaire n'est pas rempli correctement.");

            return false;
        }
    }
}
