<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\IssueMapDistricts;
use AppBundle\Form\IssueMapDistrictsType;

/**
 * IssueMapDistricts controller.
 *
 * @Route("/issuemapdistricts")
 */
class IssueMapDistrictsController extends Controller
{

    /**
     * Lists all IssueMapDistricts entities.
     *
     * @Route("/", name="issuemapdistricts")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:IssueMapDistricts')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new IssueMapDistricts entity.
     *
     * @Route("/", name="issuemapdistricts_create")
     * @Method("POST")
     * @Template("AppBundle:IssueMapDistricts:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new IssueMapDistricts();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('issuemapdistricts_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a IssueMapDistricts entity.
     *
     * @param IssueMapDistricts $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(IssueMapDistricts $entity)
    {
        $form = $this->createForm(new IssueMapDistrictsType(), $entity, array(
            'action' => $this->generateUrl('issuemapdistricts_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new IssueMapDistricts entity.
     *
     * @Route("/new", name="issuemapdistricts_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new IssueMapDistricts();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a IssueMapDistricts entity.
     *
     * @Route("/{id}", name="issuemapdistricts_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueMapDistricts')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueMapDistricts entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing IssueMapDistricts entity.
     *
     * @Route("/{id}/edit", name="issuemapdistricts_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueMapDistricts')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueMapDistricts entity.');
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
    * Creates a form to edit a IssueMapDistricts entity.
    *
    * @param IssueMapDistricts $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(IssueMapDistricts $entity)
    {
        $form = $this->createForm(new IssueMapDistrictsType(), $entity, array(
            'action' => $this->generateUrl('issuemapdistricts_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing IssueMapDistricts entity.
     *
     * @Route("/{id}", name="issuemapdistricts_update")
     * @Method("PUT")
     * @Template("AppBundle:IssueMapDistricts:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueMapDistricts')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueMapDistricts entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('issuemapdistricts_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a IssueMapDistricts entity.
     *
     * @Route("/{id}", name="issuemapdistricts_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:IssueMapDistricts')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find IssueMapDistricts entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('issuemapdistricts'));
    }

    /**
     * Creates a form to delete a IssueMapDistricts entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issuemapdistricts_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
