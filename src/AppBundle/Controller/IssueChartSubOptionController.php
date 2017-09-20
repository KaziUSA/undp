<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\IssueChartSubOption;
use AppBundle\Form\IssueChartSubOptionType;

/**
 * IssueChartSubOption controller.
 *
 * @Route("/issuechartsuboption")
 */
class IssueChartSubOptionController extends Controller
{

    /**
     * Lists all IssueChartSubOption entities.
     *
     * @Route("/", name="issuechartsuboption")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:IssueChartSubOption')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new IssueChartSubOption entity.
     *
     * @Route("/", name="issuechartsuboption_create")
     * @Method("POST")
     * @Template("AppBundle:IssueChartSubOption:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new IssueChartSubOption();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('issuechartsuboption_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a IssueChartSubOption entity.
     *
     * @param IssueChartSubOption $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(IssueChartSubOption $entity)
    {
        $form = $this->createForm(new IssueChartSubOptionType(), $entity, array(
            'action' => $this->generateUrl('issuechartsuboption_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new IssueChartSubOption entity.
     *
     * @Route("/new", name="issuechartsuboption_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new IssueChartSubOption();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a IssueChartSubOption entity.
     *
     * @Route("/{id}", name="issuechartsuboption_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueChartSubOption')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueChartSubOption entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing IssueChartSubOption entity.
     *
     * @Route("/{id}/edit", name="issuechartsuboption_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueChartSubOption')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueChartSubOption entity.');
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
    * Creates a form to edit a IssueChartSubOption entity.
    *
    * @param IssueChartSubOption $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(IssueChartSubOption $entity)
    {
        $form = $this->createForm(new IssueChartSubOptionType(), $entity, array(
            'action' => $this->generateUrl('issuechartsuboption_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing IssueChartSubOption entity.
     *
     * @Route("/{id}", name="issuechartsuboption_update")
     * @Method("PUT")
     * @Template("AppBundle:IssueChartSubOption:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueChartSubOption')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueChartSubOption entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('issuechartsuboption_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a IssueChartSubOption entity.
     *
     * @Route("/{id}", name="issuechartsuboption_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:IssueChartSubOption')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find IssueChartSubOption entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('issuechartsuboption'));
    }

    /**
     * Creates a form to delete a IssueChartSubOption entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issuechartsuboption_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
