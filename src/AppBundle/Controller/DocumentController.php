<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\Document;
use AppBundle\Form\DocumentType;

/**
 * Document controller.
 *
 * @Route("/document")
 */
class DocumentController extends Controller
{


    /**
     * Lists all Document entities.
     *
     * @Route("/", name="document")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = array('status'=> 1);
        $entities = $em->getRepository('AppBundle:Document')->findBy($criteria);

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Document entity.
     *
     * @Route("/", name="document_create")
     * @Method("POST")
     * @Template("AppBundle:Document:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Document();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('document_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Document entity.
     *
     * @param Document $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Document $entity)
    {
        $form = $this->createForm(new DocumentType(), $entity, array(
            'action' => $this->generateUrl('document_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Document entity.
     *
     * @Route("/new", name="document_new")
     * @Template()
     */
    public function newAction()
    {
        $document = new Document();
        $form = $this->createFormBuilder($document)
            //->add('name')
            ->add('name', 'text', array( 'attr' => array( 'class' => 'form-control' ) ))
            //->add('file')
            ->add('file', 'file', array( 'attr' => array( 'class' => 'form-control' ) ))
            ->add('imgFile', 'file', array( 'attr' => array( 'class' => 'form-control' ) ))
            //->add('date')
            ->add('date', 'date', array( 'attr' => array( //text
                'class' => 'form-control',//date
                //'value' => date('Y-m-d'),
                )) )
            ->add('documenttype')
            ->add('language', 'choice', array(
                'choices'  => array('english' => 'English', 'nepali' => 'Nepali'),
                // *this line is important*
                'choices_as_values' => false,
            ))
            ->add('district', 'choice', array(
                'choices'  => array(
                    '' => 'Choose district',
                    'Bhaktapur' => 'Bhaktapur',
                    'Dhading' => 'Dhading',
                    'Dolakha' => 'Dolakha',
                    'Gorkha' => 'Gorkha',
                    'Kathmandu' => 'Kathmandu',
                    'Kavrepalanchowk' => 'Kavrepalanchowk',
                    'Lalitpur' => 'Lalitpur',
                    'Makwanpur' => 'Makwanpur',
                    'Nuwakot' => 'Nuwakot',
                    'Okhaldhunga' => 'Okhaldhunga',
                    'Ramechhap' => 'Ramechhap',
                    'Rasuwa' => 'Rasuwa',
                    'Sindhuli' => 'Sindhuli',
                    'Sindhupalchowk' => 'Sindhupalchowk',
                    ),
                // *this line is important*
                'choices_as_values' => false,
            ))
            ->getForm()
        ;

        if ($this->getRequest()->getMethod() === 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                
                $document->upload();
                $document->uploadImgUrl();

                $em->persist($document);
                $em->flush();

                return $this->redirect($this->generateUrl('document_show', array('id' => $document->getId())));

                /*if(isset($_SESSION['document_upload'])) {
                    $this->get('session')->getFlashBag()->add('success', 'File uploaded successfully.');
                    $_SESSION['document_upload'] = '';//remove success message after showing until next upload
                }*/
            }
            else{
               throw $this->createNotFoundException('Form error');
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * Finds and displays a Document entity.
     *
     * @Route("/{id}", name="document_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Document entity.
     *
     * @Route("/{id}/edit", name="document_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
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
    * Creates a form to edit a Document entity.
    *
    * @param Document $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Document $entity)
    {
        $form = $this->createForm(new DocumentType(), $entity, array(
            'action' => $this->generateUrl('document_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Document entity.
     *
     * @Route("/{id}", name="document_update")
     * @Method("PUT")
     * @Template("AppBundle:Document:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

                // $document->upload();
                // $document->uploadImg();

            $em->flush();

        return $this->redirect($this->generateUrl('document_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Document entity.
     *
     * @Route("/{id}", name="document_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Document')->find($id);
        //$entity->setPath('php'.uniqid());//do not need to encrypt or change file or path name
        $entity->setStatus(0);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $em->flush();
        return $this->redirect($this->generateUrl('document'));
    }
    /**
     * Creates a form to delete a Document entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('document_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
