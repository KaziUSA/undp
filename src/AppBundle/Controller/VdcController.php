<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Vdc;
use AppBundle\Form\VdcType;

/**
 * Vdc controller.
 *
 * @Route("/vdc")
 */
class VdcController extends Controller
{

    /**
     * Lists all Vdc entities.
     *
     * @Route("/", name="vdc")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Vdc')->findAll();
        

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * Creates a new Vdc entity.
     *
     * @Route("/", name="vdc_create")
     * @Method("POST")
     * @Template("AppBundle:Vdc:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Vdc();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vdc_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Vdc entity.
     *
     * @param Vdc $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Vdc $entity)
    {
        $form = $this->createForm(new VdcType(), $entity, array(
            'action' => $this->generateUrl('vdc_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Vdc entity.
     *
     * @Route("/new", name="vdc_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Vdc();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Vdc entity.
     *
     * @Route("/{id}", name="vdc_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Vdc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vdc entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Vdc entity.
     *
     * @Route("/{id}/edit", name="vdc_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Vdc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vdc entity.');
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
    * Creates a form to edit a Vdc entity.
    *
    * @param Vdc $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Vdc $entity)
    {
        $form = $this->createForm(new VdcType(), $entity, array(
            'action' => $this->generateUrl('vdc_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Vdc entity.
     *
     * @Route("/{id}", name="vdc_update")
     * @Method("PUT")
     * @Template("AppBundle:Vdc:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Vdc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vdc entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('vdc_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Vdc entity.
     *
     * @Route("/{id}", name="vdc_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Vdc')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Vdc entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vdc'));
    }

    /**
     * Creates a form to delete a Vdc entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vdc_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    /**
     * Lists all Vdc entities by District.
     *
     * @Route("/list/{district}", name="vdc_show_district")
     * @Method("GET")
     * @Template()
     */
    public function listAction($district)
    {
        $em = $this->getDoctrine()->getManager();

        //$entities = $em->getRepository('AppBundle:Vdc')->findAll();
        $entities = $em->getRepository('AppBundle:Vdc')->findByDistrict($district);

        if (!$entities) {
            throw $this->createNotFoundException('Unable to find Vdc entity.');
        }
        

        return array(
            'entities' => $entities,
        );
    }
}
