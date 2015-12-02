<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Answeroption;
use AppBundle\Form\AnsweroptionType;

/**
 * Answeroption controller.
 *
 * @Route("/answeroption")
 */
class AnsweroptionController extends Controller
{

    /**
     * Lists all Answeroption entities.
     *
     * @Route("/", name="answeroption")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Answeroption')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Answeroption entity.
     *
     * @Route("/", name="answeroption_create")
     * @Method("POST")
     * @Template("AppBundle:Answeroption:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Answeroption();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('answeroption_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Answeroption entity.
     *
     * @param Answeroption $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Answeroption $entity)
    {
        $form = $this->createForm(new AnsweroptionType(), $entity, array(
            'action' => $this->generateUrl('answeroption_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Answeroption entity.
     *
     * @Route("/new", name="answeroption_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Answeroption();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Answeroption entity.
     *
     * @Route("/{id}", name="answeroption_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Answeroption')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Answeroption entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Answeroption entity.
     *
     * @Route("/{id}/edit", name="answeroption_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Answeroption')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Answeroption entity.');
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
    * Creates a form to edit a Answeroption entity.
    *
    * @param Answeroption $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Answeroption $entity)
    {
        $form = $this->createForm(new AnsweroptionType(), $entity, array(
            'action' => $this->generateUrl('answeroption_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Answeroption entity.
     *
     * @Route("/{id}", name="answeroption_update")
     * @Method("PUT")
     * @Template("AppBundle:Answeroption:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Answeroption')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Answeroption entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('answeroption_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Answeroption entity.
     *
     * @Route("/{id}", name="answeroption_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Answeroption')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Answeroption entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('answeroption'));
    }

    /**
     * Creates a form to delete a Answeroption entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('answeroption_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
