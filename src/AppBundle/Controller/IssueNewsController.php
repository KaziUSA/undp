<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\IssueNews;
use AppBundle\Form\IssueNewsType;

/**
 * IssueNews controller.
 *
 * @Route("/issuenews")
 */
class IssueNewsController extends Controller
{

    /**
     * Lists all IssueNews entities.
     *
     * @Route("/", name="issuenews")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:IssueNews')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new IssueNews entity.
     *
     * @Route("/", name="issuenews_create")
     * @Method("POST")
     * @Template("AppBundle:IssueNews:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new IssueNews();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            //upload image in directory
            $entity->upload();

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('issuenews_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a IssueNews entity.
     *
     * @param IssueNews $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(IssueNews $entity)
    {
        $form = $this->createForm(new IssueNewsType(), $entity, array(
            'action' => $this->generateUrl('issuenews_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new IssueNews entity.
     *
     * @Route("/new", name="issuenews_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new IssueNews();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a IssueNews entity.
     *
     * @Route("/{id}", name="issuenews_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueNews')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueNews entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing IssueNews entity.
     *
     * @Route("/{id}/edit", name="issuenews_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueNews')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueNews entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        //show the file that has been uploaded or being used
        //if video url - get the youtube slug
        $youtubeUrlEmbed = '';
        if($entity->getYoutubeUrl() != '') {
            $url = urldecode(rawurldecode($entity->getYoutubeUrl()));
            # https://www.youtube.com/watch?v=nn5hCEMyE-E

            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
            // echo $matches[1];
            // exit();
            $youtubeUrlEmbed = 'https://www.youtube.com/embed/' . $matches[1];
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'youtubeUrlEmbed' => $youtubeUrlEmbed,

        );
    }

    /**
    * Creates a form to edit a IssueNews entity.
    *
    * @param IssueNews $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(IssueNews $entity)
    {
        $form = $this->createForm(new IssueNewsType(), $entity, array(
            'action' => $this->generateUrl('issuenews_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing IssueNews entity.
     *
     * @Route("/{id}", name="issuenews_update")
     * @Method("PUT")
     * @Template("AppBundle:IssueNews:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueNews')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueNews entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            //upload image in directory
            $entity->upload();

            $em->flush();

            return $this->redirect($this->generateUrl('issuenews_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a IssueNews entity.
     *
     * @Route("/{id}", name="issuenews_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:IssueNews')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find IssueNews entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('issuenews'));
    }

    /**
     * Creates a form to delete a IssueNews entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issuenews_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
