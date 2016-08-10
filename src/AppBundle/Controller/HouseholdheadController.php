<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Householdhead;
use AppBundle\Form\HouseholdheadType;

/**
 * Householdhead controller.
 *
 * @Route("/householdhead")
 */
class HouseholdheadController extends Controller
{

    /**
     * Lists all Householdhead entities.
     *
     * @Route("/", name="householdhead")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Householdhead')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Householdhead entity.
     *
     * @Route("/", name="householdhead_create")
     * @Method("POST")
     * @Template("AppBundle:Householdhead:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Householdhead();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('householdhead_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Householdhead entity.
     *
     * @param Householdhead $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Householdhead $entity)
    {
        $form = $this->createForm(new HouseholdheadType(), $entity, array(
            'action' => $this->generateUrl('householdhead_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Householdhead entity.
     *
     * @Route("/new", name="householdhead_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Householdhead();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Householdhead entity.
     *
     * @Route("/{id}", name="householdhead_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Householdhead')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Householdhead entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Householdhead entity.
     *
     * @Route("/{id}/edit", name="householdhead_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Householdhead')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Householdhead entity.');
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
    * Creates a form to edit a Householdhead entity.
    *
    * @param Householdhead $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Householdhead $entity)
    {
        $form = $this->createForm(new HouseholdheadType(), $entity, array(
            'action' => $this->generateUrl('householdhead_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Householdhead entity.
     *
     * @Route("/{id}", name="householdhead_update")
     * @Method("PUT")
     * @Template("AppBundle:Householdhead:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Householdhead')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Householdhead entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('householdhead_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Householdhead entity.
     *
     * @Route("/{id}", name="householdhead_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Householdhead')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Householdhead entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('householdhead'));
    }

    /**
     * Creates a form to delete a Householdhead entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('householdhead_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
