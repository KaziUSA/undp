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
		$data_district = $request->request->get('data_district');
		$data_question = 1;
		//$data_age = ['15 - 24','40 - 54'];
		//$data_gender= ['Male','Female'];
		//$data_ethnicity=['Brahmin','Chhetri','Dalit'];
		//$data_district=['Kathmandu','Dolakha'];
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
		if(!isset($data_age) && !isset($data_gender) && !isset($data_ethnicity) && !isset($data_district)){ 			
		    
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
		if(isset($data_age) && !isset($data_gender) && !isset($data_ethnicity) && !isset($data_district)){
			$i=0;
			$obj['stack']='normal'; //For stack chart
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
		if(isset($data_age) && isset($data_gender) && !isset($data_ethnicity) && !isset($data_district)){
			$i=0;
			$obj['stack']='normal'; //For stack chart
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
		if(isset($data_ethnicity) && !isset($data_age) && !isset($data_gender) && !isset($data_district)){
			$i=0;
			$obj['stack']='normal';	//For stack chart
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

		//Age and Ethnicity filter selected
		if(isset($data_ethnicity) && isset($data_gender) && !isset($data_age) && !isset($data_district)){
			$i=0;
			$obj['stack']='normal'; //For stack chart
			foreach ($data_gender as $gender) {				
				foreach ($obj['answer'] as $num){	
					$obj['series'][$i]['name']= $num;  //Alternative to array_push
					$obj['series'][$i]['stack']=$gender;
					foreach ($data_ethnicity as $ethnicity){				
						$results= $em->getRepository('AppBundle\Entity\Query')->getEthnicityGender($data_question,$num,$ethnicity,$gender);
						foreach ($results as $arr){		        		
			        		$obj['series'][$i]['data'][]= (int)$arr['count'];   
			    		}					
					}				
					$i++;
				}
				$obj['label']=$data_ethnicity;
			}
		}

		//Age,Gender,District Filter selected
		if(!isset($data_ethnicity) && isset($data_gender) && isset($data_age) && isset($data_district)){
			$i=0;
			if(count($data_gender)>1){
				$district_span=count($data_age)*2;
			}
			else{
				$district_span=count($data_age);
			}
			$gender_span=count($data_age);
			$obj['stack']='normal'; //For stack chart
			$obj['html']="<table id='' class='table table-bordered'><thead>";
			$obj['html']=$obj['html']."<tr><th>City</th>";
			for($j=0;$j<count($data_district);$j++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Gender</th>";
			for($j=0;$j<count($data_district);$j++){
				for($k=0;$k<count($data_gender);$k++){
					$obj['html']=$obj['html']."<th colspan='".$gender_span."'>".$data_gender[$k]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Age Group</th>";
			if(count($data_gender)>1){				
				for($i=0;$i<count($data_district);$i++){
					for($j=0;$j<count($data_gender);$j++){
						for($k=0;$k<count($data_age);$k++){
							$obj['html']=$obj['html']."<th>".$data_age[$k]."</th>";				        
						}
					}
				}
			}
			else{
				for($i=0;$i<count($data_district);$i++){	
					for($k=0;$k<count($data_age);$k++){
						$obj['html']=$obj['html']."<th>".$data_age[$k]."</th>";				        
					}
				}
			}
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_district as $district) {			
					//$obj['html']=$obj['html'].<
					foreach ($data_gender as $gender) {
						foreach ($data_age as $age) {			       									       
							$results= $em->getRepository('AppBundle\Entity\Query')->getAgeDistrictGender($data_question,$ans,$district,$gender,$age);
							foreach ($results as $arr){		        		
			        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";   
			    			}	
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

				//Ethnicity,Gender,District Filter selected
		if(isset($data_ethnicity) && isset($data_gender) && !isset($data_age) && isset($data_district)){
			$i=0;
			if(count($data_gender)>1){
				$district_span=count($data_ethnicity)*2;
			}
			else{
				$district_span=count($data_ethnicity);
			}
			$gender_span=count($data_ethnicity);			
			$obj['html']="<table id='' class='table table-bordered'><thead>";
			$obj['html']=$obj['html']."<tr><th>City</th>";
			for($j=0;$j<count($data_district);$j++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Gender</th>";
			for($j=0;$j<count($data_district);$j++){
				for($k=0;$k<count($data_gender);$k++){
					$obj['html']=$obj['html']."<th colspan='".$gender_span."'>".$data_gender[$k]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Ethnicity</th>";
			if(count($data_gender)>1){				
				for($i=0;$i<count($data_district);$i++){
					for($j=0;$j<count($data_gender);$j++){
						for($k=0;$k<count($data_ethnicity);$k++){
							$obj['html']=$obj['html']."<th>".$data_ethnicity[$k]."</th>";				        
						}
					}
				}
			}
			else{
				for($i=0;$i<count($data_district);$i++){	
					for($k=0;$k<count($data_ethnicity);$k++){
						$obj['html']=$obj['html']."<th>".$data_ethnicity[$k]."</th>";				        
					}
				}
			}
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_district as $district) {
					foreach ($data_gender as $gender) {
						foreach ($data_ethnicity as $ethnicity) {			       									       
							$results= $em->getRepository('AppBundle\Entity\Query')->getEthnicityDistrictGender($data_question,$ans,$district,$gender,$ethnicity);
							foreach ($results as $arr){		        		
			        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";   
			    			}	
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}
		//prepare the response
		$response = array("code" => 100, "success" => true, "result"=> $obj);
		//return result as JSON
		return new Response(json_encode($response));
	}      
}