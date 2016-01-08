<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Pdf;
use AppBundle\Form\PdfType;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Pdf controller.
 *
 * @Route("/pdf")
 */
class PdfController extends Controller
{

    /**
     * Lists all Pdf entities.
     *
     * @Route("/", name="pdf")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Pdf')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Pdf entity.
     *
     * @Route("/", name="pdf_create")
     * @Method("POST")
     * @Template("AppBundle:Pdf:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Pdf();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pdf_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Pdf entity.
     *
     * @param Pdf $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Pdf $entity)
    {
        $form = $this->createForm(new PdfType(), $entity, array(
            'action' => $this->generateUrl('pdf_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Pdf entity.
     *
     * @Route("/new", name="pdf_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Pdf();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Pdf entity.
     *
     * @Route("/{id}", name="pdf_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pdf')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pdf entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Pdf entity.
     *
     * @Route("/{id}/edit", name="pdf_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pdf')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pdf entity.');
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
    * Creates a form to edit a Pdf entity.
    *
    * @param Pdf $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pdf $entity)
    {
        $form = $this->createForm(new PdfType(), $entity, array(
            'action' => $this->generateUrl('pdf_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Pdf entity.
     *
     * @Route("/{id}", name="pdf_update")
     * @Method("PUT")
     * @Template("AppBundle:Pdf:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pdf')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pdf entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pdf_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Pdf entity.
     *
     * @Route("/{id}", name="pdf_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Pdf')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pdf entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pdf'));
    }

    /**
     * Creates a form to delete a Pdf entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pdf_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
