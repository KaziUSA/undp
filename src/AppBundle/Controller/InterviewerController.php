<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Interviewer;
use AppBundle\Form\InterviewerType;

/**
 * Interviewer controller.
 *
 * @Route("/interviewer")
 */
class InterviewerController extends Controller
{

    /**
     * Lists all Interviewer entities.
     *
     * @Route("/", name="interviewer")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Interviewer')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Interviewer entity.
     *
     * @Route("/", name="interviewer_create")
     * @Method("POST")
     * @Template("AppBundle:Interviewer:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Interviewer();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('interviewer_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Interviewer entity.
     *
     * @param Interviewer $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Interviewer $entity)
    {
        $form = $this->createForm(new InterviewerType(), $entity, array(
            'action' => $this->generateUrl('interviewer_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create',
            'attr' => array( 'class' => 'btn btn-success btn-xs' )
            ));

        return $form;
    }

    /**
     * Displays a form to create a new Interviewer entity.
     *
     * @Route("/new", name="interviewer_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Interviewer();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Interviewer entity.
     *
     * @Route("/{id}", name="interviewer_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Interviewer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Interviewer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Interviewer entity.
     *
     * @Route("/{id}/edit", name="interviewer_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Interviewer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Interviewer entity.');
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
    * Creates a form to edit a Interviewer entity.
    *
    * @param Interviewer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Interviewer $entity)
    {
        $form = $this->createForm(new InterviewerType(), $entity, array(
            'action' => $this->generateUrl('interviewer_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update',
            'attr' => array( 'class' => 'btn btn-xs btn-success' )
            ));

        return $form;
    }
    /**
     * Edits an existing Interviewer entity.
     *
     * @Route("/{id}", name="interviewer_update")
     * @Method("PUT")
     * @Template("AppBundle:Interviewer:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Interviewer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Interviewer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('interviewer_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Interviewer entity.
     *
     * @Route("/{id}", name="interviewer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Interviewer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Interviewer entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('interviewer'));
    }

    /**
     * Creates a form to delete a Interviewer entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('interviewer_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete',
                'attr' => array( 'class' => 'btn btn-xs btn-success' )
                ))
            ->getForm()
        ;
    }
}
