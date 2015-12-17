<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
/**
 * Myajax controller.
 *
 * @Route("/myajax")
 */


class MyAjaxController extends Controller
{
	
	/**    
     * @Route("/", name="myajax")
     * @Method("POST")
     * @Template()
     */
	public function indexAction(Request $request){
	// $request = $this->container->get('request');        
	$obj=array(array());
	$obj['label']=array();
	$obj['count']=array();
	$data_question = $request->request->get('data_question');
	$data2 = $request->request->get('data2');

	//$data2 = $_POST['data2'];
	//handle data
	
	//$sql = "SELECT COUNT(*) as count FROM `survey_response` INNER JOIN `survey` ON survey.id = survey_response.survey_id INNER JOIN question ON survey_response.question_id = question.id WHERE question.id = :id";
	$sql= "SELECT a.name FROM question AS q INNER JOIN answer AS a ON q.answer_group_id=a.answer_group_id WHERE q.id= :id";
	$em = $this->getDoctrine()->getEntityManager();
    $connection = $em->getConnection();
    $statement = $connection->prepare($sql);
    $statement->bindValue('id', $data_question);
    $statement->execute();
    $results = $statement->fetchAll();    
    foreach ($results as $num){
        array_push($obj['label'], $num['name']);   
    }
	unset($num);   
    foreach ($obj['label'] as $num){
    	$sql= 'SELECT count(*) as count
		FROM `survey_response` AS s INNER JOIN answer AS a ON s.answer_id=a.id 
		 WHERE s.question_id = :qnid AND a.name = :name';
		//$connection = $em->getConnection();		
		$statement = $connection->prepare($sql);
		$statement->bindValue('qnid', $data_question);
		$statement->bindValue('name', $num);
		$statement->execute();
	 	$results = $statement->fetchAll();
	 	foreach ($results as $arr){
        array_push($obj['count'], $arr['count']);   
    	}    	
    }
	//prepare the response
	$response = array("code" => 100, "success" => true, "result"=> $obj);
	//return result as JSON
	return new Response(json_encode($response)); 
	}      
}