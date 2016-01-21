<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Occupation;
use AppBundle\Form\OccupationType;

/**
 * Occupation controller.
 *
 * @Route("/occupation")
 */
class OccupationController extends Controller
{

    /**
     * Lists all Occupation entities.
     *
     * @Route("/", name="occupation")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Occupation')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Occupation entity.
     *
     * @Route("/", name="occupation_create")
     * @Method("POST")
     * @Template("AppBundle:Occupation:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Occupation();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('occupation_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Occupation entity.
     *
     * @param Occupation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Occupation $entity)
    {
        $form = $this->createForm(new OccupationType(), $entity, array(
            'action' => $this->generateUrl('occupation_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Occupation entity.
     *
     * @Route("/new", name="occupation_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Occupation();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Occupation entity.
     *
     * @Route("/{id}", name="occupation_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Occupation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Occupation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Occupation entity.
     *
     * @Route("/{id}/edit", name="occupation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Occupation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Occupation entity.');
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
    * Creates a form to edit a Occupation entity.
    *
    * @param Occupation $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Occupation $entity)
    {
        $form = $this->createForm(new OccupationType(), $entity, array(
            'action' => $this->generateUrl('occupation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Occupation entity.
     *
     * @Route("/{id}", name="occupation_update")
     * @Method("PUT")
     * @Template("AppBundle:Occupation:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Occupation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Occupation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('occupation_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Occupation entity.
     *
     * @Route("/{id}", name="occupation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Occupation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Occupation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('occupation'));
    }

    /**
     * Creates a form to delete a Occupation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('occupation_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
