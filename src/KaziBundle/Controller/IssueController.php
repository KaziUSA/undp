<?php

namespace KaziBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

// use AppBundle\Entity\Document;
// use AppBundle\Form\DocumentType;

/**
 * Document controller.
 *
 * @Route("/issue")
 */
class IssueController extends Controller
{


    /**
     * Lists all Document entities.
     *
     * @Route("/", name="issue")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        /*$criteria = array('status'=> 1);

        $entities = $em->getRepository('AppBundle:Document')->findBy($criteria, array('date'=>'desc'));*/

        
        //TODO: redirect to latest issue first question




        return array(
            'issue_questions' => 'no need to pass anything',
        );
    }


    /**
     * Finds and displays all data from excel
     *
     * @Route("/{id}", name="issue_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)//$id 
    {
        $em = $this->getDoctrine()->getManager();
        
        /*$criteria = array('status'=> 1);

        $entities = $em->getRepository('AppBundle:Document')->findBy($criteria, array('date'=>'desc'));*/

        

        //getting all issue questions
        $issue_questions = $em->getRepository('AppBundle:IssueQuestion')->findAll();


        //getting detail of this question id
        $question_detail = $em->getRepository('AppBundle:IssueQuestion')->findById($id);
        // var_dump($question_detail); exit();

        return array(
            'issue_questions' => $issue_questions,
            'question_detail' => $question_detail[0],
        );

    }
}
