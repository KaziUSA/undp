<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\IssueMapName;
use AppBundle\Form\IssueMapNameType;

/**
 * IssueMapName controller.
 *
 * @Route("/issuemapname")
 */
class IssueMapNameController extends Controller
{

    /**
     * Lists all IssueMapName entities.
     *
     * @Route("/", name="issuemapname")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:IssueMapName')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new IssueMapName entity.
     *
     * @Route("/", name="issuemapname_create")
     * @Method("POST")
     * @Template("AppBundle:IssueMapName:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new IssueMapName();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('issuemapname_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a IssueMapName entity.
     *
     * @param IssueMapName $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(IssueMapName $entity)
    {
        $form = $this->createForm(new IssueMapNameType(), $entity, array(
            'action' => $this->generateUrl('issuemapname_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new IssueMapName entity.
     *
     * @Route("/new", name="issuemapname_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new IssueMapName();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a IssueMapName entity.
     *
     * @Route("/{id}", name="issuemapname_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueMapName')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueMapName entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing IssueMapName entity.
     *
     * @Route("/{id}/edit", name="issuemapname_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueMapName')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueMapName entity.');
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
    * Creates a form to edit a IssueMapName entity.
    *
    * @param IssueMapName $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(IssueMapName $entity)
    {
        $form = $this->createForm(new IssueMapNameType(), $entity, array(
            'action' => $this->generateUrl('issuemapname_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing IssueMapName entity.
     *
     * @Route("/{id}", name="issuemapname_update")
     * @Method("PUT")
     * @Template("AppBundle:IssueMapName:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueMapName')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueMapName entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('issuemapname_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a IssueMapName entity.
     *
     * @Route("/{id}", name="issuemapname_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:IssueMapName')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find IssueMapName entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('issuemapname'));
    }

    /**
     * Creates a form to delete a IssueMapName entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issuemapname_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
