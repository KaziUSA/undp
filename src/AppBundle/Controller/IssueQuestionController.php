<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use AppBundle\Entity\IssueQuestion;
use AppBundle\Form\IssueQuestionType;

/**
 * IssueQuestion controller.
 *
 * @Route("/issuequestion")
 */
class IssueQuestionController extends Controller
{

    /**
     * Lists all IssueQuestion entities.
     *
     * @Route("/", name="issuequestion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:IssueQuestion')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new IssueQuestion entity.
     *
     * @Route("/", name="issuequestion_create")
     * @Method("POST")
     * @Template("AppBundle:IssueQuestion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new IssueQuestion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            //upload image in directory
            $entity->upload();

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            //redirect to edit page instead ... - so that user can go back to previous or next form
            return $this->redirect($this->generateUrl('issuequestion_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a IssueQuestion entity.
     *
     * @param IssueQuestion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(IssueQuestion $entity)
    {
        $form = $this->createForm(new IssueQuestionType(), $entity, array(
            'action' => $this->generateUrl('issuequestion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new IssueQuestion entity.
     *
     * @Route("/new", name="issuequestion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new IssueQuestion();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a IssueQuestion entity.
     *
     * @Route("/{id}", name="issuequestion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueQuestion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueQuestion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing IssueQuestion entity.
     *
     * @Route("/{id}/edit", name="issuequestion_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueQuestion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueQuestion entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);


        //show if it has all other forms filled or need to be created so that 
        //we can redirect to already filled form or redirect to new form
        //1. view if chart question has been filled or not
        $chart_question = $em->getRepository('AppBundle:IssueChartQuestion')->findByIssueQuestion($id);
        // var_dump($chart_question); exit();
        //now creating proper array
        $question_option = array();

        $i = 0;
        foreach ($chart_question as $cq) {
            // var_dump($cq);
            $question_option[$i]['id'] = $cq->getId();
            $question_option[$i]['name'] = $cq->getName();
            $question_option[$i]['chartType'] = $cq->getChartType();

            
            //get charts option of each chart question
            $chart_option = $em->getRepository('AppBundle:IssueChartOption')->findByIssueChartQuestion( $cq->getId() );//TODO: chart question id to be passed
            // var_dump($chart_option); exit();    

            $question_option[$i]['option'] = (array) $chart_option;

            $i++;
        }
        // var_dump($question_option); exit();



        //get infographics title
        $infographics_title = $em->getRepository('AppBundle:IssueInfographicsTitle')->findByIssueQuestion($id);
        // var_dump($infographics_title); exit();


        //now creating proper array
        $infographics = array();

        $i = 0;
        foreach ($infographics_title as $it) {
            // var_dump($it);
            $infographics[$i]['id'] = $it->getId();
            $infographics[$i]['name'] = $it->getName();
            $infographics[$i]['type'] = $it->getType();
            /* 1 - Vertical, 2 - Horizontal, 3 - Percentage - vertical */

            
            //get charts option of each chart question
            $infographics_list = $em->getRepository('AppBundle:IssueInfographics')->findByIssueInfographicsTitle( $it->getId() );//TODO: chart question id to be passed
            // var_dump($infographics_list); exit();    

            $infographics[$i]['option'] = (array) $infographics_list;

            $i++;
        }
        // var_dump($infographics); exit();



        //issue map sayings
        $question_id = $id;
        $sayings = $em->getRepository('AppBundle:IssueMapSayings')->findByIssueQuestion($question_id);
        // var_dump($sayings); exit();


        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),

            'question_option' => $question_option,
            'infographics' => $infographics,
            'sayings' => $sayings,
        );
    }

    /**
    * Creates a form to edit a IssueQuestion entity.
    *
    * @param IssueQuestion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(IssueQuestion $entity)
    {
        $form = $this->createForm(new IssueQuestionType(), $entity, array(
            'action' => $this->generateUrl('issuequestion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing IssueQuestion entity.
     *
     * @Route("/{id}", name="issuequestion_update")
     * @Method("PUT")
     * @Template("AppBundle:IssueQuestion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:IssueQuestion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueQuestion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            //upload image in directory
            $entity->upload();

            $em->flush();

            return $this->redirect($this->generateUrl('issuequestion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a IssueQuestion entity.
     *
     * @Route("/{id}", name="issuequestion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:IssueQuestion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find IssueQuestion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('issuequestion'));
    }

    /**
     * Creates a form to delete a IssueQuestion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issuequestion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
