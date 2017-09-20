<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\IssueNewsType;
use AppBundle\Form\IssueNewsTypeType;

/**
 * IssueNewsType controller.
 *
 * @Route("/issuenewstype")
 */
class IssueNewsTypeController extends Controller
{

    /**
     * Lists all IssueNewsType entities.
     *
     * @Route("/", name="issuenewstype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:IssueNewsType')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new IssueNewsType entity.
     *
     * @Route("/", name="issuenewstype_create")
     * @Method("POST")
     * @Template("AppBundle:IssueNewsType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new IssueNewsType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('issuenewstype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a IssueNewsType entity.
     *
     * @param IssueNewsType $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(IssueNewsType $entity)
    {
        $form = $this->createForm(new IssueNewsTypeType(), $entity, array(
            'action' => $this->generateUrl('issuenewstype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new IssueNewsType entity.
     *
     * @Route("/new", name="issuenewstype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new IssueNewsType();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a IssueNewsType entity.
     *
     * @Route("/{id}", name="issuenewstype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueNewsType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueNewsType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing IssueNewsType entity.
     *
     * @Route("/{id}/edit", name="issuenewstype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueNewsType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueNewsType entity.');
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
    * Creates a form to edit a IssueNewsType entity.
    *
    * @param IssueNewsType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(IssueNewsType $entity)
    {
        $form = $this->createForm(new IssueNewsTypeType(), $entity, array(
            'action' => $this->generateUrl('issuenewstype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing IssueNewsType entity.
     *
     * @Route("/{id}", name="issuenewstype_update")
     * @Method("PUT")
     * @Template("AppBundle:IssueNewsType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueNewsType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueNewsType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('issuenewstype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a IssueNewsType entity.
     *
     * @Route("/{id}", name="issuenewstype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:IssueNewsType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find IssueNewsType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('issuenewstype'));
    }

    /**
     * Creates a form to delete a IssueNewsType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issuenewstype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
