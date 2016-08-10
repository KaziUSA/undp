<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Cardtype;
use AppBundle\Form\CardtypeType;

/**
 * Cardtype controller.
 *
 * @Route("/cardtype")
 */
class CardtypeController extends Controller
{

    /**
     * Lists all Cardtype entities.
     *
     * @Route("/", name="cardtype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Cardtype')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Cardtype entity.
     *
     * @Route("/", name="cardtype_create")
     * @Method("POST")
     * @Template("AppBundle:Cardtype:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Cardtype();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cardtype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Cardtype entity.
     *
     * @param Cardtype $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cardtype $entity)
    {
        $form = $this->createForm(new CardtypeType(), $entity, array(
            'action' => $this->generateUrl('cardtype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Cardtype entity.
     *
     * @Route("/new", name="cardtype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Cardtype();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Cardtype entity.
     *
     * @Route("/{id}", name="cardtype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Cardtype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cardtype entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Cardtype entity.
     *
     * @Route("/{id}/edit", name="cardtype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Cardtype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cardtype entity.');
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
    * Creates a form to edit a Cardtype entity.
    *
    * @param Cardtype $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cardtype $entity)
    {
        $form = $this->createForm(new CardtypeType(), $entity, array(
            'action' => $this->generateUrl('cardtype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Cardtype entity.
     *
     * @Route("/{id}", name="cardtype_update")
     * @Method("PUT")
     * @Template("AppBundle:Cardtype:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Cardtype')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cardtype entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cardtype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Cardtype entity.
     *
     * @Route("/{id}", name="cardtype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Cardtype')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cardtype entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cardtype'));
    }

    /**
     * Creates a form to delete a Cardtype entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cardtype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
