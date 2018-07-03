<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Data;

/**
 * Age controller.
 *
 * @Route("/data")
 */
class DataController extends Controller
{

    /**
     * Lists all Age entities.
     *
     * @Route("/", name="data")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        //Flashbag: value 1 is stored just after user logged in in LoginLister.php
        //1 - just logged in
        //2 - already logged in (or to not repeat Welcome message again and again)
        if(isset($_SESSION['login_success'])) {
            if($_SESSION["login_success"] == "1") {
                $this->get('session')->getFlashBag()->add('success', 'Welcome!');
                $_SESSION["login_success"] = "2";
            }
        }

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Data')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Age entity.
     *
     * @Route("/store", name="data_create")
     * @Method("POST")
     * @Template("AppBundle:Data:new.html.twig")
     */
    public function createAction(Request $request)
    {
        // var_dump($request->request->get('title'));

         // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        //Save File
        $file = $request->files->get('file');
        $fileName = time() ."-". $file->getClientOriginalName();
        $fileName = str_replace(' ', '-', $fileName);
        $image = '/data_files/' .$fileName;
        $upload_success= $file->move('data_files', $fileName);

        //Save to database
        $data = new Data();
        $data->setTitle($request->request->get('title'));
        $data->setFile($fileName);
        $data->setYear($request->request->get('year'));
        $data->setMonth($request->request->get('month'));

        // tell Doctrine you want to (eventually) save the data (no queries yet)
        $entityManager->persist($data);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirect($this->generateUrl('data'));
    }

    /**
     * Creates a form to create a Age entity.
     *
     * @param Age $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Data $entity)
    {
        $form = $this->createForm(new Data(), $entity, array(
            'action' => $this->generateUrl('data_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create',
            'attr' => array( 'class' => 'btn btn-xs btn-success' )
            ));

        return $form;
    }

    /**
     * Displays a form to create a new Data entity.
     *
     * @Route("/new", name="data_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Data();
        // $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            // 'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Age entity.
     *
     * @Route("/{id}", name="age_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Age')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Age entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Age entity.
     *
     * @Route("/{id}/edit", name="data_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Data')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Data entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
    * Creates a form to edit a Age entity.
    *
    * @param Data $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Data $entity)
    {
        $form = $this->createForm(new AgeType(), $entity, array(
            'action' => $this->generateUrl('age_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update',
            'attr' => array( 'class' => 'btn btn-xs btn-success' )
            ));

        return $form;
    }
    /**
     * Edits an existing Data entity.
     *
     * @Route("/{id}", name="data_update")
     * @Method("PUT")
     * @Template("AppBundle:Data:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Age')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Age entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('age_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Age entity.
     *
     * @Route("/{id}", name="age_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Age')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Age entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('age'));
    }

    /**
     * Creates a form to delete a Age entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('age_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete',
                'attr' => array( 'class' => 'btn btn-xs btn-success' )
                ))
            ->getForm()
        ;
    }
}
