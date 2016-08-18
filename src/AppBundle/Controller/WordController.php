<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

use AppBundle\Entity\Word;

/**
 * WordController
 */
class WordController extends Controller
{
    /**
     * Lists all Words.
     *
     * @Route("/word")
     */
    public function indexAction()
    {
        // Get entity manager
        $em = $this->getDoctrine()->getManager();

        // Retrieve Words
        $words = $em->getRepository('AppBundle:Word')->findAllQB();

        return $this->render('/word/index.html.twig', array(
            'words' => $words,
        ));
    }

    /**
     * Displays a form to create a new Word.
     *
     * @Route("/word/new")
     */
    public function newAction()
    {
        // Get request and entity manager
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        // Create Word form
        $word = new Word();
        $form = $this->createForm('AppBundle\Form\WordType', $word);

        // Process the form
        if ($this->process($form, $request, $em)) {
            return $this->redirect($this->generateUrl('app_word_edit', array('id' => $word->getId())));
        }

        return $this->render('/word/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Word.
     *
     * @Route("/word/edit/{id}", requirements={"id": "\d+"})
     *
     * @param Word $word
     */
    public function editAction(Word $word)
    {
        // Get request and entity manager
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        // Create Word form
        $form = $this->createForm('AppBundle\Form\WordType', $word);

        // Process the form
        if ($this->process($form, $request, $em)) {
            return $this->redirect($this->generateUrl('app_word_edit', array('id' => $word->getId())));
        }

        return $this->render('/word/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a Word.
     *
     * @Route("/word/delete/{id}", requirements={"id": "\d+"})
     *
     * @param Word $word
     */
    public function deleteAction(Word $word)
    {
        // Get entity manager
        $em = $this->getDoctrine()->getManager();

        // Remove and flush
        $em->remove($word);
        $em->flush();

        return $this->redirect($this->generateUrl('app_word_index'));
    }

    /**
     * Creates/Updates a Word.
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
