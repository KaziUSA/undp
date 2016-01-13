<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Page;
use AppBundle\Form\PageType;

/**
 * Page controller.
 *
 * @Route("/page")
 */
class PageController extends Controller
{

    /**
     * Lists all Page entities.
     *
     * @Route("/", name="page")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Page')->findAll();
        //print_r($entities);exit();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Page entity.
     *
     * @Route("/", name="page_create")
     * @Method("POST")
     * @Template("AppBundle:Page:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Page();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('page_show', array('slug' => $entity->getSlug())));//id
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Page entity.
     *
     * @param Page $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Page $entity)
    {
        $form = $this->createForm(new PageType(), $entity, array(
            'action' => $this->generateUrl('page_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Page entity.
     *
     * @Route("/new", name="page_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Page();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Page entity.
     *
     * @Route("/{slug}", name="page_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($slug)//$id
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = array('slug'=> $slug);
        $id = 2;//TODO: get id from slug

        $entity = $em->getRepository('AppBundle:Page')->find($id);//$id - id with key 'o' error
        //print_r($entity);exit();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($slug);//$id

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Route("/{slug}/edit", name="page_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($slug)//$id
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = array('slug'=>$slug);
        $id = 2;//TODO: get id from slug

        $entity = $em->getRepository('AppBundle:Page')->find($id);//find($id) - instance of entity
        //print_r($entity);exit();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($slug);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Page entity.
    *
    * @param Page $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Page $entity)
    {
        $form = $this->createForm(new PageType(), $entity, array(
            'action' => $this->generateUrl('page_update', array('slug' => $entity->getSlug())),//id
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Page entity.
     *
     * @Route("/{slug}", name="page_update")
     * @Method("PUT")
     * @Template("AppBundle:Page:edit.html.twig")
     */
    public function updateAction(Request $request, $slug)//$id
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = array('slug'=>$slug);
        $id = 2;//TODO: get id from $slug

        $entity = $em->getRepository('AppBundle:Page')->find($id);//$id - instance of entity

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($slug);//$id
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('page_edit', array('slug' => $slug)));//$id
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Page entity.
     *
     * @Route("/{slug}", name="page_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $slug)//$id
    {
        $form = $this->createDeleteForm($slug);//$id
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $criteria = array('slug'=>$slug);
            $entity = $em->getRepository('AppBundle:Page')->findBy($criteria);//$id

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Page entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('page'));
    }

    /**
     * Creates a form to delete a Page entity by slug.
     *
     * @param mixed $slug The entity slug
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($slug)//$id
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('page_delete', array('slug' => $slug)))//$id
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
