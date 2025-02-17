<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\SurveyResponse;
use AppBundle\Form\SurveyResponseType;

/**
 * SurveyResponse controller.
 *
 * @Route("/surveyresponse")
 */
class SurveyResponseController extends Controller
{

    /**
     * Lists all SurveyResponse entities.
     *
     * @Route("/", name="surveyresponse")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:SurveyResponse')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new SurveyResponse entity.
     *
     * @Route("/", name="surveyresponse_create")
     * @Method("POST")
     * @Template("AppBundle:SurveyResponse:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SurveyResponse();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('surveyresponse_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a SurveyResponse entity.
     *
     * @param SurveyResponse $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SurveyResponse $entity)
    {
        $form = $this->createForm(new SurveyResponseType(), $entity, array(
            'action' => $this->generateUrl('surveyresponse_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SurveyResponse entity.
     *
     * @Route("/new", name="surveyresponse_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SurveyResponse();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a SurveyResponse entity.
     *
     * @Route("/{id}", name="surveyresponse_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:SurveyResponse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SurveyResponse entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SurveyResponse entity.
     *
     * @Route("/{id}/edit", name="surveyresponse_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:SurveyResponse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SurveyResponse entity.');
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
    * Creates a form to edit a SurveyResponse entity.
    *
    * @param SurveyResponse $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SurveyResponse $entity)
    {
        $form = $this->createForm(new SurveyResponseType(), $entity, array(
            'action' => $this->generateUrl('surveyresponse_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SurveyResponse entity.
     *
     * @Route("/{id}", name="surveyresponse_update")
     * @Method("PUT")
     * @Template("AppBundle:SurveyResponse:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:SurveyResponse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SurveyResponse entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('surveyresponse_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a SurveyResponse entity.
     *
     * @Route("/{id}", name="surveyresponse_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:SurveyResponse')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SurveyResponse entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('surveyresponse'));
    }

    /**
     * Creates a form to delete a SurveyResponse entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('surveyresponse_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
