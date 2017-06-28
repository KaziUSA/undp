<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\IssueChartQuestion;
use AppBundle\Form\IssueChartQuestionType;

use AppBundle\Helper\IssueChartQuestionHelper;
use Symfony\Component\HttpFoundation\Response;

/**
 * IssueChartQuestion controller.
 *
 * @Route("/issuechartquestion")
 */
class IssueChartQuestionController extends Controller
{

    /**
     * Lists all IssueChartQuestion entities.
     *
     * @Route("/", name="issuechartquestion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:IssueChartQuestion')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all IssueType entities.
     *
     * @Route("/detail", name="issuechartquestion_detail")
     * @Template()
     */
    public function detailAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        #handle the ajax request - to show which issueType is selected
            $data_id = $request->request->get('data_id');
            // $data_id = 10;//eg. Are your main reconstruction needs ... is of Reconstruction - Feb 2017
            $ith = new IssueChartQuestionHelper();
            if($data_id != '') {
                $response = $ith->getIssueChartQuestionDetail($em, $data_id);

                return new Response(json_encode($response));
            }
        #end ajax request

        exit();
        return false;
    }

    /**
     * Creates a new IssueChartQuestion entity.
     *
     * @Route("/", name="issuechartquestion_create")
     * @Method("POST")
     * @Template("AppBundle:IssueChartQuestion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new IssueChartQuestion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('issuechartquestion_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a IssueChartQuestion entity.
     *
     * @param IssueChartQuestion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(IssueChartQuestion $entity)
    {
        $form = $this->createForm(new IssueChartQuestionType(), $entity, array(
            'action' => $this->generateUrl('issuechartquestion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new IssueChartQuestion entity.
     *
     * @Route("/new", name="issuechartquestion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new IssueChartQuestion();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a IssueChartQuestion entity.
     *
     * @Route("/{id}", name="issuechartquestion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueChartQuestion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueChartQuestion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing IssueChartQuestion entity.
     *
     * @Route("/{id}/edit", name="issuechartquestion_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueChartQuestion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueChartQuestion entity.');
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
    * Creates a form to edit a IssueChartQuestion entity.
    *
    * @param IssueChartQuestion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(IssueChartQuestion $entity)
    {
        $form = $this->createForm(new IssueChartQuestionType(), $entity, array(
            'action' => $this->generateUrl('issuechartquestion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing IssueChartQuestion entity.
     *
     * @Route("/{id}", name="issuechartquestion_update")
     * @Method("PUT")
     * @Template("AppBundle:IssueChartQuestion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueChartQuestion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueChartQuestion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('issuechartquestion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a IssueChartQuestion entity.
     *
     * @Route("/{id}", name="issuechartquestion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:IssueChartQuestion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find IssueChartQuestion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('issuechartquestion'));
    }

    /**
     * Creates a form to delete a IssueChartQuestion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issuechartquestion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
