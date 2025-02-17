<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\IssueChartOption;
use AppBundle\Form\IssueChartOptionType;

/**
 * IssueChartOption controller.
 *
 * @Route("/issuechartoption")
 */
class IssueChartOptionController extends Controller
{

    /**
     * Lists all IssueChartOption entities.
     *
     * @Route("/", name="issuechartoption")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:IssueChartOption')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new IssueChartOption entity.
     *
     * @Route("/", name="issuechartoption_create")
     * @Method("POST")
     * @Template("AppBundle:IssueChartOption:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new IssueChartOption();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('issuechartoption_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a IssueChartOption entity.
     *
     * @param IssueChartOption $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(IssueChartOption $entity)
    {
        $form = $this->createForm(new IssueChartOptionType(), $entity, array(
            'action' => $this->generateUrl('issuechartoption_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new IssueChartOption entity.
     *
     * @Route("/new", name="issuechartoption_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new IssueChartOption();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a IssueChartOption entity.
     *
     * @Route("/{id}", name="issuechartoption_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueChartOption')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueChartOption entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing IssueChartOption entity.
     *
     * @Route("/{id}/edit", name="issuechartoption_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueChartOption')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueChartOption entity.');
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
    * Creates a form to edit a IssueChartOption entity.
    *
    * @param IssueChartOption $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(IssueChartOption $entity)
    {
        $form = $this->createForm(new IssueChartOptionType(), $entity, array(
            'action' => $this->generateUrl('issuechartoption_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing IssueChartOption entity.
     *
     * @Route("/{id}", name="issuechartoption_update")
     * @Method("PUT")
     * @Template("AppBundle:IssueChartOption:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueChartOption')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueChartOption entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('issuechartoption_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a IssueChartOption entity.
     *
     * @Route("/{id}", name="issuechartoption_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:IssueChartOption')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find IssueChartOption entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('issuechartoption'));
    }

    /**
     * Creates a form to delete a IssueChartOption entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issuechartoption_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
