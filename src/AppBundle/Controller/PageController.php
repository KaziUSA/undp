<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
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
     * 
     * @Template()
     */
    public function indexAction(Request $request)//annotation removed @Method("GET")
    {
        //for frontend homepage only
        $data_id = $request->request->get('data_id');
        $data_title = $request->request->get('data_title');
        $data_description = $request->request->get('data_description');

        $sql= "UPDATE page SET title=\"$data_title\",description=\"$data_description\" WHERE id=\"$data_id\"";

        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare($sql);
        $statement->bindValue('id', $data_id);
        $statement->execute();
        //prepare the response
        $response = array("code" => 100, "success" => true);



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
     * @Route("/create", name="page_create")
     * @Method("POST")
     * @Template("AppBundle:Page:new.html.twig")
     */
    public function createAction(Request $request)//added /create - because new item is not being able to create after implementing ajax post in show page
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
     * 
     * @Template()
     */
    public function newAction()//removed @Method("GET") for file upload - banner
    {
        $entity = new Page();
        //$form   = $this->createCreateForm($entity);

        $form = $this->createFormBuilder($entity)
            //->add('name')
            ->add('slug', 'text', array( 'attr' => array( 'class' => 'form-control' ) ))
            //->add('file')
            ->add('title', 'text', array( 'attr' => array( 'class' => 'form-control') ))
            ->add('description')
            ->add('file', 'file', array( 
                'required' => false,
                'attr' => array( 'class' => 'form-control' ) ))
            //->add('date')
            ->getForm()
        ;

        if ($this->getRequest()->getMethod() === 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $entity->upload();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('page_show', array('slug' => $entity->getSlug())));//id
            }
            else{
               throw $this->createNotFoundException('Form error');
            }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Page entity.
     *
     * @Route("/{slug}", name="page_show")
     * 
     * @Template()
     */
    public function showAction($slug, Request $request)//$id //removed annotation @Method("GET")
    {
        $data_id = $request->request->get('data_id');
        $data_title = mysql_real_escape_string($request->request->get('data_title'));
        $data_description = mysql_real_escape_string($request->request->get('data_description'));

        $sql= "UPDATE page SET title=\"$data_title\",description=\"$data_description\" WHERE id=\"$data_id\"";

        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare($sql);
        $statement->bindValue('id', $data_id);
        $statement->execute();
        //prepare the response
        $response = array("code" => 100, "success" => true);
        
        $em = $this->getDoctrine()->getManager();
        $criteria = array('slug'=> $slug);

        $entity_for_id = $em->getRepository('AppBundle:Page')->findBy($criteria);
        //print_r($entity_for_id); exit();
        $id = $entity_for_id['0']->getId();

        $entity = $em->getRepository('AppBundle:Page')->find($id);//$id - id with key 'o' error
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($slug);//$id

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
            json_encode($response),
        );
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Route("/{slug}/edit", name="page_edit")
     * 
     * @Template()
     */
    public function editAction($slug)//$id - removed @Method("GET") for file upload
    {
        //TODO: need to edit uploaded banner image
        $em = $this->getDoctrine()->getManager();
        $criteria = array('slug'=>$slug);
        
        $entity_for_id = $em->getRepository('AppBundle:Page')->findBy($criteria);
        $id = $entity_for_id['0']->getId();

        $entity = $em->getRepository('AppBundle:Page')->find($id);//find($id) - instance of entity
        //print_r($entity);exit();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        //$editForm = $this->createEditForm($entity);
        $editForm = $this->createFormBuilder($entity)
            //TODO: Need to show the previously uploaded banner image
            ->add('file', 'file', array( 'attr' => array( 'class' => 'form-control' ) ))
            ->getForm()
        ;

        if ($this->getRequest()->getMethod() === 'POST') {
            $editForm->bind($this->getRequest());
            if ($editForm->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $entity->upload();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('page_show', array('slug' => $entity->getSlug())));//id
            }
            else{
               throw $this->createNotFoundException('Form error');
            }
        }

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

        $entity_for_id = $em->getRepository('AppBundle:Page')->findBy($criteria);
        $id = $entity_for_id['0']->getId();

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
     * @Route("/{slug}/delete", name="page_delete")
     * 
     */
    public function deleteAction(Request $request, $slug)//$id - removed @Method("DELETE") for file upload and /delete added after making show page editable using ajax 
    {
        $form = $this->createDeleteForm($slug);//$id
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $criteria = array('slug'=>$slug);
            
            $entity_for_id = $em->getRepository('AppBundle:Page')->findBy($criteria);
            $id = $entity_for_id['0']->getId();
            
            $entity = $em->getRepository('AppBundle:Page')->find($id);//$id

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
