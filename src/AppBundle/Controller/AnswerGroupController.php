<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\AnswerGroup;
use AppBundle\Form\AnswerGroupType;

/**
 * AnswerGroup controller.
 *
 * @Route("/answergroup")
 */
class AnswerGroupController extends Controller
{

    /**
     * Lists all AnswerGroup entities.
     *
     * @Route("/", name="answergroup")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:AnswerGroup')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new AnswerGroup entity.
     *
     * @Route("/", name="answergroup_create")
     * @Method("POST")
     * @Template("AppBundle:AnswerGroup:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new AnswerGroup();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('answergroup_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a AnswerGroup entity.
     *
     * @param AnswerGroup $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AnswerGroup $entity)
    {
        $form = $this->createForm(new AnswerGroupType(), $entity, array(
            'action' => $this->generateUrl('answergroup_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AnswerGroup entity.
     *
     * @Route("/new", name="answergroup_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new AnswerGroup();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a AnswerGroup entity.
     *
     * @Route("/{id}", name="answergroup_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AnswerGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnswerGroup entity.');
        }
        
        $repository = $this->getDoctrine()->getRepository('AppBundle:Answer');
        //$answers = $repository->findByAnswerGroupId($id);
        $entityManager = $this->getDoctrine()->getEntityManager();
        $answers = $entityManager->getRepository('AppBundle:Answer')->findBy(array('answer_group' => $id));
        
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'answers'     => $answers,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing AnswerGroup entity.
     *
     * @Route("/{id}/edit", name="answergroup_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AnswerGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnswerGroup entity.');
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
    * Creates a form to edit a AnswerGroup entity.
    *
    * @param AnswerGroup $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AnswerGroup $entity)
    {
        $form = $this->createForm(new AnswerGroupType(), $entity, array(
            'action' => $this->generateUrl('answergroup_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing AnswerGroup entity.
     *
     * @Route("/{id}", name="answergroup_update")
     * @Method("PUT")
     * @Template("AppBundle:AnswerGroup:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:AnswerGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnswerGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('answergroup_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a AnswerGroup entity.
     *
     * @Route("/{id}", name="answergroup_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:AnswerGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AnswerGroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('answergroup'));
    }

    /**
     * Creates a form to delete a AnswerGroup entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('answergroup_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
