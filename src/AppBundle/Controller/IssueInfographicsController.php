<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\IssueInfographics;
use AppBundle\Form\IssueInfographicsType;

/**
 * IssueInfographics controller.
 *
 * @Route("/issueinfographics")
 */
class IssueInfographicsController extends Controller
{

    /**
     * Lists all IssueInfographics entities.
     *
     * @Route("/", name="issueinfographics")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:IssueInfographics')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new IssueInfographics entity.
     *
     * @Route("/", name="issueinfographics_create")
     * @Method("POST")
     * @Template("AppBundle:IssueInfographics:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new IssueInfographics();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('issueinfographics_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a IssueInfographics entity.
     *
     * @param IssueInfographics $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(IssueInfographics $entity)
    {
        $form = $this->createForm(new IssueInfographicsType(), $entity, array(
            'action' => $this->generateUrl('issueinfographics_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new IssueInfographics entity.
     *
     * @Route("/new", name="issueinfographics_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new IssueInfographics();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a IssueInfographics entity.
     *
     * @Route("/{id}", name="issueinfographics_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueInfographics')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueInfographics entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing IssueInfographics entity.
     *
     * @Route("/{id}/edit", name="issueinfographics_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueInfographics')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueInfographics entity.');
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
    * Creates a form to edit a IssueInfographics entity.
    *
    * @param IssueInfographics $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(IssueInfographics $entity)
    {
        $form = $this->createForm(new IssueInfographicsType(), $entity, array(
            'action' => $this->generateUrl('issueinfographics_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing IssueInfographics entity.
     *
     * @Route("/{id}", name="issueinfographics_update")
     * @Method("PUT")
     * @Template("AppBundle:IssueInfographics:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueInfographics')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueInfographics entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('issueinfographics_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a IssueInfographics entity.
     *
     * @Route("/{id}", name="issueinfographics_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:IssueInfographics')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find IssueInfographics entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('issueinfographics'));
    }

    /**
     * Creates a form to delete a IssueInfographics entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issueinfographics_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
