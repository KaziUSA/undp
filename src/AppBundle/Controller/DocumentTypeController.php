<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\DocumentType;
use AppBundle\Form\DocumentTypeType;

/**
 * DocumentType controller.
 *
 * @Route("/documenttype")
 */
class DocumentTypeController extends Controller
{

    /**
     * Lists all DocumentType entities.
     *
     * @Route("/", name="documenttype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:DocumentType')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new DocumentType entity.
     *
     * @Route("/", name="documenttype_create")
     * @Method("POST")
     * @Template("AppBundle:DocumentType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new DocumentType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('documenttype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a DocumentType entity.
     *
     * @param DocumentType $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DocumentType $entity)
    {
        $form = $this->createForm(new DocumentTypeType(), $entity, array(
            'action' => $this->generateUrl('documenttype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DocumentType entity.
     *
     * @Route("/new", name="documenttype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new DocumentType();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a DocumentType entity.
     *
     * @Route("/{id}", name="documenttype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:DocumentType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocumentType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing DocumentType entity.
     *
     * @Route("/{id}/edit", name="documenttype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:DocumentType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocumentType entity.');
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
    * Creates a form to edit a DocumentType entity.
    *
    * @param DocumentType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DocumentType $entity)
    {
        $form = $this->createForm(new DocumentTypeType(), $entity, array(
            'action' => $this->generateUrl('documenttype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DocumentType entity.
     *
     * @Route("/{id}", name="documenttype_update")
     * @Method("PUT")
     * @Template("AppBundle:DocumentType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:DocumentType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DocumentType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('documenttype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a DocumentType entity.
     *
     * @Route("/{id}", name="documenttype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:DocumentType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DocumentType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('documenttype'));
    }

    /**
     * Creates a form to delete a DocumentType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('documenttype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
