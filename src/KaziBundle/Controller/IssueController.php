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


        
        return $this->redirect($this->generateUrl('issue_show', array('id' => '1')));

        /*return array(
            'issue_questions' => 'no need to pass anything',
        );*/
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
        $issue_questions = $em->getRepository('AppBundle:IssueQuestion')
            ->findAll();
            /*->findBy(
                array('issueType' => '1')
                array('month' => 'ASC')
                );*/
        // var_dump($issue_questions); exit();        


        //getting detail of this question id
        $question_detail = $em->getRepository('AppBundle:IssueQuestion')->findById($id);
        // var_dump($question_detail); exit();

        //get distinct issueTypes
        $issueType_detail = $em->getRepository('AppBundle:IssueType')->findAll();
        if($id == 1) {
            // var_dump($issueType_detail); exit();
        }




        //get charts questions
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

            // $question_option[$i]['option'] = (array) $chart_option;


            $chart_option_arr = (array) $chart_option;

            $question_option[$i]['option'] = array();
            
            //debug
            // if($id == 2) {
                // $question_option[$i]['option']['suboption'] = array();
                // get charts sub option too
                $oi = 0;//option increment
                foreach ($chart_option_arr as $co) {
                    // var_dump($co);
                    $question_option[$i]['option'][$oi]['id'] = $co->getId();
                    $question_option[$i]['option'][$oi]['name'] = $co->getName();
                    $question_option[$i]['option'][$oi]['value'] = $co->getValue();


                    $chart_sub_option = $em->getRepository('AppBundle:IssueChartSubOption')->findByIssueChartOption( $co->getId() );

                    $question_option[$i]['option'][$oi]['suboption'] = (array) $chart_sub_option;



                    $oi++;
                }
            // }//end if $id == 2


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



        return array(
            'issue_questions' => $issue_questions,
            'question_detail' => $question_detail[0],//their will be always single question detail
            // 'chart_question' => $chart_question,//send final one - chart question option
            'question_option' => $question_option,
            'infographics' => $infographics,
            'issueType' => $issueType_detail,// for dropdown of issueType (Month year) under eg. Reconstruction tab
        );

    }
}
