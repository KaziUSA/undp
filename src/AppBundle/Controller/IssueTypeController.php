<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\IssueType;
use AppBundle\Form\IssueTypeType;

use AppBundle\Helper\IssueTypeHelper;
use Symfony\Component\HttpFoundation\Response;

/**
 * IssueType controller.
 *
 * @Route("/issuetype")
 */
class IssueTypeController extends Controller
{

    /**
     * Lists all IssueType entities.
     *
     * @Route("/", name="issuetype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:IssueType')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all IssueType entities.
     *
     * @Route("/detail", name="issuetype_detail")
     * @Template()
     */
    public function detailAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        #handle the ajax request - to show which issueType is selected
            $data_id = $request->request->get('data_id');
            $ith = new IssueTypeHelper();
            if($data_id != '') {
                $response = $ith->getIssueTypeDetail($em, $data_id);

                return new Response(json_encode($response));
            }
        #end ajax request

        exit();
        return false;
    }

    /**
     * Creates a new IssueType entity.
     *
     * @Route("/", name="issuetype_create")
     * @Method("POST")
     * @Template("AppBundle:IssueType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new IssueType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('issuetype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a IssueType entity.
     *
     * @param IssueType $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(IssueType $entity)
    {
        $form = $this->createForm(new IssueTypeType(), $entity, array(
            'action' => $this->generateUrl('issuetype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new IssueType entity.
     *
     * @Route("/new", name="issuetype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new IssueType();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a IssueType entity.
     *
     * @Route("/{id}", name="issuetype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing IssueType entity.
     *
     * @Route("/{id}/edit", name="issuetype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueType entity.');
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
    * Creates a form to edit a IssueType entity.
    *
    * @param IssueType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(IssueType $entity)
    {
        $form = $this->createForm(new IssueTypeType(), $entity, array(
            'action' => $this->generateUrl('issuetype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing IssueType entity.
     *
     * @Route("/{id}", name="issuetype_update")
     * @Method("PUT")
     * @Template("AppBundle:IssueType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('issuetype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a IssueType entity.
     *
     * @Route("/{id}", name="issuetype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:IssueType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find IssueType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('issuetype'));
    }

    /**
     * Creates a form to delete a IssueType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issuetype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
