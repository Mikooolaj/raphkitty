<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

use AppBundle\Entity\User;

/**
 * UserController
 */
class UserController extends Controller
{
    /**
     * Lists all Users.
     *
     * @Route("/user")
     */
    public function indexAction()
    {
        // Get entity manager
        $em = $this->getDoctrine()->getManager();

        // Retrieve Users
        $users = $em->getRepository('AppBundle:User')->findAllQB();

        return $this->render('/user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Displays a form to create a new User.
     *
     * @Route("/user/new")
     */
    public function newAction()
    {
        // Get request and entity manager
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        // Create User form
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);

        // Process the form
        if ($this->process($form, $request, $em)) {
            return $this->redirect($this->generateUrl('app_user_edit', array('id' => $user->getId())));
        }

        return $this->render('/user/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User.
     *
     * @Route("/user/edit/{id}", requirements={"id": "\d+"})
     *
     * @param User $user
     */
    public function editAction(User $user)
    {
        // Get request and entity manager
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        // Create User form
        $form = $this->createForm('AppBundle\Form\UserType', $user);

        // Process the form
        if ($this->process($form, $request, $em)) {
            return $this->redirect($this->generateUrl('app_user_edit', array('id' => $user->getId())));
        }

        return $this->render('/user/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a User.
     *
     * @Route("/user/delete/{id}", requirements={"id": "\d+"})
     *
     * @param User $user
     */
    public function deleteAction(User $user)
    {
        // Get entity manager
        $em = $this->getDoctrine()->getManager();

        // Remove and flush
        $em->remove($user);
        $em->flush();

        return $this->redirect($this->generateUrl('app_user_index'));
    }

    /**
     * Creates/Updates a User.
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
