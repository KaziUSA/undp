<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Cardholder;
use AppBundle\Form\CardholderType;

/**
 * Cardholder controller.
 *
 * @Route("/cardholder")
 */
class CardholderController extends Controller
{

    /**
     * Lists all Cardholder entities.
     *
     * @Route("/", name="cardholder")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Cardholder')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Cardholder entity.
     *
     * @Route("/", name="cardholder_create")
     * @Method("POST")
     * @Template("AppBundle:Cardholder:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Cardholder();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cardholder_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Cardholder entity.
     *
     * @param Cardholder $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cardholder $entity)
    {
        $form = $this->createForm(new CardholderType(), $entity, array(
            'action' => $this->generateUrl('cardholder_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Cardholder entity.
     *
     * @Route("/new", name="cardholder_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Cardholder();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Cardholder entity.
     *
     * @Route("/{id}", name="cardholder_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Cardholder')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cardholder entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Cardholder entity.
     *
     * @Route("/{id}/edit", name="cardholder_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Cardholder')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cardholder entity.');
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
    * Creates a form to edit a Cardholder entity.
    *
    * @param Cardholder $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cardholder $entity)
    {
        $form = $this->createForm(new CardholderType(), $entity, array(
            'action' => $this->generateUrl('cardholder_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Cardholder entity.
     *
     * @Route("/{id}", name="cardholder_update")
     * @Method("PUT")
     * @Template("AppBundle:Cardholder:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Cardholder')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cardholder entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cardholder_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Cardholder entity.
     *
     * @Route("/{id}", name="cardholder_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Cardholder')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cardholder entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cardholder'));
    }

    /**
     * Creates a form to delete a Cardholder entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cardholder_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
