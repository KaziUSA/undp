<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\IssueInfographicsTitle;
use AppBundle\Form\IssueInfographicsTitleType;

use AppBundle\Helper\IssueInfographicsTitleHelper;
use Symfony\Component\HttpFoundation\Response;

/**
 * IssueInfographicsTitle controller.
 *
 * @Route("/issueinfographicstitle")
 */
class IssueInfographicsTitleController extends Controller
{

    /**
     * Lists all IssueInfographicsTitle entities.
     *
     * @Route("/", name="issueinfographicstitle")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:IssueInfographicsTitle')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all IssueType entities.
     *
     * @Route("/detail", name="issueinfographicstitle_detail")
     * @Template()
     */
    public function detailAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        #handle the ajax request - to show which issueType is selected
            $data_id = $request->request->get('data_id');
            // $data_id = 10;//eg. Are your main reconstruction needs ... is of Reconstruction - Feb 2017
            $ith = new IssueInfographicsTitleHelper();
            if($data_id != '') {
                $response = $ith->getIssueInfographicsTitleDetail($em, $data_id);

                return new Response(json_encode($response));
            }
        #end ajax request

        exit();
        return false;
    }

    /**
     * Creates a new IssueInfographicsTitle entity.
     *
     * @Route("/", name="issueinfographicstitle_create")
     * @Method("POST")
     * @Template("AppBundle:IssueInfographicsTitle:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new IssueInfographicsTitle();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('issueinfographicstitle_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a IssueInfographicsTitle entity.
     *
     * @param IssueInfographicsTitle $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(IssueInfographicsTitle $entity)
    {
        $form = $this->createForm(new IssueInfographicsTitleType(), $entity, array(
            'action' => $this->generateUrl('issueinfographicstitle_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new IssueInfographicsTitle entity.
     *
     * @Route("/new", name="issueinfographicstitle_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new IssueInfographicsTitle();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a IssueInfographicsTitle entity.
     *
     * @Route("/{id}", name="issueinfographicstitle_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueInfographicsTitle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueInfographicsTitle entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing IssueInfographicsTitle entity.
     *
     * @Route("/{id}/edit", name="issueinfographicstitle_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueInfographicsTitle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueInfographicsTitle entity.');
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
    * Creates a form to edit a IssueInfographicsTitle entity.
    *
    * @param IssueInfographicsTitle $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(IssueInfographicsTitle $entity)
    {
        $form = $this->createForm(new IssueInfographicsTitleType(), $entity, array(
            'action' => $this->generateUrl('issueinfographicstitle_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing IssueInfographicsTitle entity.
     *
     * @Route("/{id}", name="issueinfographicstitle_update")
     * @Method("PUT")
     * @Template("AppBundle:IssueInfographicsTitle:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueInfographicsTitle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueInfographicsTitle entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('issueinfographicstitle_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a IssueInfographicsTitle entity.
     *
     * @Route("/{id}", name="issueinfographicstitle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:IssueInfographicsTitle')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find IssueInfographicsTitle entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('issueinfographicstitle'));
    }

    /**
     * Creates a form to delete a IssueInfographicsTitle entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issueinfographicstitle_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
