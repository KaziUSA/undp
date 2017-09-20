<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\IssueChartOverview;
use AppBundle\Form\IssueChartOverviewType;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * IssueChartOverview controller.
 *
 * @Route("/issuechartoverview")
 */
class IssueChartOverviewController extends Controller
{

    /**
     * Lists all IssueChartOverview entities.
     *
     * @Route("/", name="issuechartoverview")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:IssueChartOverview')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new IssueChartOverview entity.
     *
     * @Route("/", name="issuechartoverview_create")
     * @Method("POST")
     * @Template("AppBundle:IssueChartOverview:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new IssueChartOverview();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('issuechartoverview_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a IssueChartOverview entity.
     *
     * @param IssueChartOverview $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(IssueChartOverview $entity)
    {
        $form = $this->createForm(new IssueChartOverviewType(), $entity, array(
            'action' => $this->generateUrl('issuechartoverview_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new IssueChartOverview entity.
     *
     * @Route("/new", name="issuechartoverview_new")     
     * @Template()
     * @Method("GET") removed
     */
    public function newAction()
    {        

        $entity = new IssueChartOverview();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a IssueChartOverview entity.
     *
     * @Route("/{id}", name="issuechartoverview_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueChartOverview')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueChartOverview entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing IssueChartOverview entity.
     *
     * @Route("/{id}/edit", name="issuechartoverview_edit")
     * @Template()
     * @Method("GET") removed
     */
    public function editAction($id)
    {        

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueChartOverview')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueChartOverview entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);


        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            // 'entity_issueType' => $entity_issueType,
        );
    }

    /**
    * Creates a form to edit a IssueChartOverview entity.
    *
    * @param IssueChartOverview $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(IssueChartOverview $entity)
    {
        $form = $this->createForm(new IssueChartOverviewType(), $entity, array(
            'action' => $this->generateUrl('issuechartoverview_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing IssueChartOverview entity.
     *
     * @Route("/{id}", name="issuechartoverview_update")
     * @Method("PUT")
     * @Template("AppBundle:IssueChartOverview:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueChartOverview')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueChartOverview entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('issuechartoverview_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a IssueChartOverview entity.
     *
     * @Route("/{id}", name="issuechartoverview_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:IssueChartOverview')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find IssueChartOverview entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('issuechartoverview'));
    }

    /**
     * Creates a form to delete a IssueChartOverview entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issuechartoverview_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
