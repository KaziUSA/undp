<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Home;
use AppBundle\Form\HomeType;
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
		$obj['series']=array();
		$obj['series']['name']=array();
		$obj['series']['data']=array();
		$data_question = $request->request->get('data_question');
		$data_age = $request->request->get('data_age');

		
		//Handle data
		
		//Store the answers of the selected question in $obj['label']
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
		//Any filters not selected		
		if(!isset($data_age)){ 
			
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
		}
		//Only age filter selected
		if(isset($data_age)){
			foreach ($obj['label'] as $num){
				foreach ($data_age as $age){
					$sql='SELECT count(*) as count FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id INNER JOIN answer AS a ON sr.answer_id=a.id INNER JOIN `age` AS ag ON s.age_id=ag.id WHERE ag.name=:agname AND sr.question_id = :qnid AND a.name = :name  ';
					$statement = $connection->prepare($sql);
					$statement->bindValue('agname', $age);
					$statement->bindValue('qnid', $data_question);
					$statement->bindValue('name', $num);
					$statement->execute();
				 	$results = $statement->fetchAll();
					foreach ($results as $arr){
		        		array_push($obj['series']['name'], $age);
		        		array_push($obj['series']['data'], $arr['count']);   
		    		} 
				}
			}
		}
		//prepare the response
		$response = array("code" => 100, "success" => true, "result"=> $obj);
		//return result as JSON
		return new Response(json_encode($response));
	}      
}