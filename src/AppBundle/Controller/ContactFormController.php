<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\ContactForm;
use AppBundle\Form\ContactFormType;

/**
 * ContactForm controller.
 *
 * @Route("/contactform")
 */
class ContactFormController extends Controller
{

    /**
     * Lists all ContactForm entities.
     *
     * @Route("/", name="contactform")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
       $entity = new ContactForm();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
        
        // $em = $this->getDoctrine()->getManager();

        // $entities = $em->getRepository('AppBundle:ContactForm')->findAll();

        // return array(
        //     'entities' => $entities,
        // );
    }
    /**
     * Creates a new ContactForm entity.
     *
     * @Route("/", name="contactform_create")
     * @Method("POST")
     * @Template("AppBundle:ContactForm:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ContactForm();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contactform_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ContactForm entity.
     *
     * @param ContactForm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ContactForm $entity)
    {
        $form = $this->createForm(new ContactFormType(), $entity, array(
            'action' => $this->generateUrl('contactform_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Send'));

        return $form;
    }

    /**
     * Displays a form to create a new ContactForm entity.
     *
     * @Route("/new", name="contactform_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ContactForm();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ContactForm entity.
     *
     * @Route("/{id}", name="contactform_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ContactForm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContactForm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ContactForm entity.
     *
     * @Route("/{id}/edit", name="contactform_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ContactForm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContactForm entity.');
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
    * Creates a form to edit a ContactForm entity.
    *
    * @param ContactForm $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ContactForm $entity)
    {
        $form = $this->createForm(new ContactFormType(), $entity, array(
            'action' => $this->generateUrl('contactform_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ContactForm entity.
     *
     * @Route("/{id}", name="contactform_update")
     * @Method("PUT")
     * @Template("AppBundle:ContactForm:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ContactForm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContactForm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('contactform_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ContactForm entity.
     *
     * @Route("/{id}", name="contactform_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:ContactForm')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ContactForm entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contactform'));
    }

    /**
     * Creates a form to delete a ContactForm entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contactform_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
