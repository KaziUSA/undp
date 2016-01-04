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
     * @Method("GET")
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
		 $data_gender = $request->request->get('data_gender');
		 $data_ethnicity= $request->request->get('data_ethnicity');
		 $data_question = 1;
		 $data_age = ['15 - 24','40 - 54'];
		$data_gender= ['Male','Female'];
		$data_ethnicity=['Brahmin','Chhetri','Dalit']
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
		if(!isset($data_age,$data_gender,$data_ethnicity)){ 			
		    
		    foreach ($obj['answer'] as $num){		  
		    	$results = $em->getRepository('AppBundle\Entity\Query')->getBasicArray($data_question,$num);
			 	foreach ($results as $arr){
		        	//array_push($obj['count'], (int)$arr['count']);   
		    		$obj['series'][$i]['data'][]= (int)$arr['count'];
		    	}    	
		    	
		    	$obj['label']=$obj['answer'];
		    }			 
		}
		//Only age filter selected
		if(isset($data_age) && !isset($data_gender,$data_ethnicity)){
			$i=0;
			foreach ($obj['answer'] as $num){	
				$obj['series'][$i]['name']= $num;  //Alternative to array_push
				foreach ($data_age as $age){
					$results= $em->getRepository('AppBundle\Entity\Query')->getAgeFilteredArray($data_question,$num,$age);
					foreach ($results as $arr){		        		
		        		$obj['series'][$i]['data'][]= (int)$arr['count'];   
		    		}					
				}				
			$i++;
			}
			$obj['label']=$data_age;
		}

		//Age and Gender filter selected
		if(isset($data_age,$data_gender) && !isset($data_ethnicity)){
			$i=0;
			$obj['stack']='normal';
			foreach ($data_gender as $gender) {				
				foreach ($obj['answer'] as $num){	
					$obj['series'][$i]['name']= $num;  //Alternative to array_push
					$obj['series'][$i]['stack']=$gender;
					foreach ($data_age as $age){				
						$results= $em->getRepository('AppBundle\Entity\Query')->getAgeGender($data_question,$num,$age,$gender);
						foreach ($results as $arr){		        		
			        		$obj['series'][$i]['data'][]= (int)$arr['count'];   
			    		}					
					}				
					$i++;
				}
				$obj['label']=$data_age;
			}
		}

		//Only ethnicity filter selected
		if(isset($data_ethnicity) && !isset($data_age,$data_gender)){
			$i=0;
			foreach ($obj['answer'] as $num){	
				$obj['series'][$i]['name']= $num;  //Alternative to array_push
				foreach ($data_ethnicity as $ethnicity){
					$results= $em->getRepository('AppBundle\Entity\Query')->getEthnicityFilteredArray($data_question,$num,$ethnicity);
					foreach ($results as $arr){		        		
		        		$obj['series'][$i]['data'][]= (int)$arr['count'];   
		    		}					
				}				
			$i++;
			}
			$obj['label']=$data_ethnicity;
		}
		//prepare the response
		$response = array("code" => 100, "success" => true, "result"=> $obj);
		//return result as JSON
		return new Response(json_encode($response));
	}      
}