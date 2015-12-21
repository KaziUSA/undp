<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Age;
use AppBundle\Form\AgeType;

/**
 * Age controller.
 *
 * @Route("/age")
 */
class AgeController extends Controller
{

    /**
     * Lists all Age entities.
     *
     * @Route("/", name="age")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        //Flashbag: value 1 is stored just after user logged in in LoginLister.php
        //1 - just logged in
        //2 - already logged in (or to not repeat Welcome message again and again)
        if($_SESSION["success"] == "1") {
            $this->get('session')->getFlashBag()->add('success', 'Welcome!');
            $_SESSION["success"] = "2";
        }

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Age')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Age entity.
     *
     * @Route("/", name="age_create")
     * @Method("POST")
     * @Template("AppBundle:Age:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Age();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('age_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Age entity.
     *
     * @param Age $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Age $entity)
    {
        $form = $this->createForm(new AgeType(), $entity, array(
            'action' => $this->generateUrl('age_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Age entity.
     *
     * @Route("/new", name="age_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Age();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Age entity.
     *
     * @Route("/{id}", name="age_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Age')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Age entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Age entity.
     *
     * @Route("/{id}/edit", name="age_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Age')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Age entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Age entity.
    *
    * @param Age $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Age $entity)
    {
        $form = $this->createForm(new AgeType(), $entity, array(
            'action' => $this->generateUrl('age_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Age entity.
     *
     * @Route("/{id}", name="age_update")
     * @Method("PUT")
     * @Template("AppBundle:Age:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Age')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Age entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('age_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Age entity.
     *
     * @Route("/{id}", name="age_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Age')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Age entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('age'));
    }

    /**
     * Creates a form to delete a Age entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('age_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
