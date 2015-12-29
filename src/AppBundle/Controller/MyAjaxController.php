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
		$i=0;
		$obj=array(array());
		$obj['answer']=array();
		$obj['count']=array();
		$obj['series']=array();
		// $obj['series']['name']=array();
		// $obj['series']['data']=array();
		 $data_question = $request->request->get('data_question');
		 $data_age = $request->request->get('data_age');
		// $data_question = 1;
		 //$data_age = ['15 - 24','40 - 54'];
		
		//Handle data
		
		//Store the answers of the selected question in $obj['answer']\
		$em = $this->getDoctrine()->getEntityManager();
		$connection = $em->getConnection();		
		//Get all the answer sets of the retrieved question id
		$answers = $em->getRepository('AppBundle\Entity\Query')->getAnswersArray($data_question);  
		foreach ($answers as $num){
	        array_push($obj['answer'], $num['name']);   
	    }
		unset($num);   
		//Any filters not selected		
		if(!isset($data_age)){ 			
		    
		    foreach ($obj['answer'] as $num){
		  //   	$sql= 'SELECT count(*) as count
				// FROM `survey_response` AS s INNER JOIN answer AS a ON s.answer_id=a.id 
				//  WHERE s.question_id = :qnid AND a.name = :name';
				// $connection = $em->getConnection();		
				// $statement = $connection->prepare($sql);
				// $statement->bindValue('qnid', $data_question);
				// $statement->bindValue('name', $num);
				// $statement->execute();
			 // 	$results = $statement->fetchAll();
		    	$results = $em->getRepository('AppBundle\Entity\Query')->getBasicArray($data_question,$num);
			 	foreach ($results as $arr){
		        	//array_push($obj['count'], (int)$arr['count']);   
		    		$obj['series'][$i]['data'][]= (int)$arr['count'];
		    	}    	
		    	
		    	$obj['label']=$obj['answer'];
		    }			 
		}
		//Only age filter selected
		if(isset($data_age)){
			$i=0;
			foreach ($obj['answer'] as $num){	
				$obj['series'][$i]['name']= $num;  //Alternative to array_push
				foreach ($data_age as $age){					
					// $sql='SELECT count(*) as count FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id INNER JOIN answer AS a ON sr.answer_id=a.id INNER JOIN `age` AS ag ON s.age_id=ag.id WHERE ag.name=:agname AND sr.question_id = :qnid AND a.name = :name  ';
					// $statement = $connection->prepare($sql);
					// $statement->bindValue('agname', $age);
					// $statement->bindValue('qnid', $data_question);
					// $statement->bindValue('name', $num);
					// $statement->execute();
				 	//$results = $statement->fetchAll();
					$results= $em->getRepository('AppBundle\Entity\Query')->getAgeFilteredArray($data_question,$num,$age);
					foreach ($results as $arr){		        		
		        		$obj['series'][$i]['data'][]= (int)$arr['count'];   
		    		}					
				}				
			$i++;
			}
			$obj['label']=$data_age;
		}
		//prepare the response
		$response = array("code" => 100, "success" => true, "result"=> $obj);
		//return result as JSON
		return new Response(json_encode($response));
	}      
}