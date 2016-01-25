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
		$flag=0;
		$obj=array(array());
		$obj['total']=0;
		$obj['answer']=array();
		$obj['count']=array();
		//$obj['series']=array();
		$obj['label']=array();
		// $obj['series']['name']=array();
		// $obj['series']['data']=array();
		$data_question = $request->request->get('data_question');
		$data_age = $request->request->get('data_age');
		$data_gender = $request->request->get('data_gender');
		$data_ethnicity= $request->request->get('data_ethnicity');
		$data_district = $request->request->get('data_district');
		$data_month = $request->request->get('data_month');
		$data_disability=$request->request->get('data_disability');
		$data_year = $request->request->get('data_year');
		$colors=['#095d67','#7af2fe','#ffdf8e','#4b98d1','#2c9d48','#30efad','#9bbd3b','#588C73','#D96459'];
		//$data_question = 1;
		//$data_age = ['15 - 24','25 - 39','40 - 54'];
		//$data_gender= ['Male','Female'];
		//$data_ethnicity=['Brahmin','Chhetri','Dalit'];
		//$data_district=['Kathmandu','Dolakha'];
		//$data_month=['January','July','August','September'];
		//$data_disability=1;
		//$data_year='2015';
		$obj['height']=514;
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
		//Any filters not selected	(1.N)	
		if(!isset($data_age) && !isset($data_gender) && !isset($data_ethnicity) && !isset($data_district) && !isset($data_month)){ 			
		    
		   foreach ($obj['answer'] as $num){		  
		    	$results = $em->getRepository('AppBundle\Entity\Query')->getBasicArray($data_question,$num,$data_disability,$data_year);
			 	foreach ($results as $arr){
		        	//array_push($obj['count'], (int)$arr['count']);   
		    		$obj['series'][$i]['data'][]= (int)$arr['count'];
		    		$obj['total'] += (int)$arr['count'];
		    	}    	
		    	
		    	//$obj['label']=$obj['answer'];
		    }			 
			
			$obj['html']='<table></table>';
		    $obj['label']=$obj['answer'];
			$obj['height']=340;
		}

		//Only Month filter selected(2.M)
		if(!isset($data_age) && !isset($data_gender) && !isset($data_ethnicity) && !isset($data_district) && isset($data_month)){
			$i=0;
			$obj['stack']='normal'; //For stack chart
			foreach ($obj['answer'] as $num){	
				$obj['series'][$i]['name']= $num;  //Alternative to array_push
				foreach ($data_month as $month){
					$results= $em->getRepository('AppBundle\Entity\Query')->getMonthFilteredArray($data_question,$num,$month,$data_disability,$data_year);
					foreach ($results as $arr){		        		
		        		$obj['series'][$i]['data'][]= (int)$arr['count'];   
		    			$obj['total'] += (int)$arr['count'];
		    		}					
				}				
			$i++;
			}
			$obj['html']='';
			$obj['label']=$data_month;
			$obj['xlabel']='Month';//Set for category name on table created by highchart getTable() method
			
			$i=0;					
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";			
			$obj['html']=$obj['html']."<tr><th>Month</th>";				
			for($k=0;$k<count($data_month);$k++){
				$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
			}						
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";				
				foreach ($data_month as $month) {			       									       
					$results= $em->getRepository('AppBundle\Entity\Query')->getMonthFilteredArray($data_question,$ans,$month,$data_disability,$data_year);
					foreach ($results as $arr){		        		
			    		$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";
			    		$obj['total'] += (int)$arr['count'];  
	    			}	
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

		//Only District filter selected(3.D)
		if(!isset($data_age) && !isset($data_gender) && !isset($data_ethnicity) && isset($data_district) && !isset($data_month)){
			$i=0;
			$obj['stack']='normal'; //For stack chart
			foreach ($obj['answer'] as $num){	
				$obj['series'][$i]['name']= $num;  //Alternative to array_push
				foreach ($data_district as $district){
					$results= $em->getRepository('AppBundle\Entity\Query')->getDistrictFilteredArray($data_question,$num,$district,$data_disability,$data_year);
					foreach ($results as $arr){		        		
		        		$obj['series'][$i]['data'][]= (int)$arr['count']; 
		        		$obj['total'] += (int)$arr['count'];  
		    		}					
				}				
			$i++;
			}
			$obj['label']=$data_district;
			$obj['xlabel']='District';
			
			$i=0;					
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";			
			$obj['html']=$obj['html']."<tr><th>District</th>";				
			for($k=0;$k<count($data_district);$k++){
				$obj['html']=$obj['html']."<th>".$data_district[$k]."</th>";				        
			}						
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";				
				foreach ($data_district as $district) {			       									       
					$results= $em->getRepository('AppBundle\Entity\Query')->getDistrictFilteredArray($data_question,$ans,$district,$data_disability,$data_year);
					foreach ($results as $arr){		        		
			    		$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";
			    		$obj['total'] += (int)$arr['count'];  
	    			}	
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

		//Only Gender filter selected(4.G)
		if(!isset($data_age) && isset($data_gender) && !isset($data_ethnicity) && !isset($data_district) && !isset($data_month)){
			$i=0;
			$obj['stack']='normal'; //For stack chart
			foreach ($obj['answer'] as $num){	
				$obj['series'][$i]['name']= $num;  //Alternative to array_push
				foreach ($data_gender as $gender){
					$results= $em->getRepository('AppBundle\Entity\Query')->getGenderFilteredArray($data_question,$num,$gender,$data_disability,$data_year);
					foreach ($results as $arr){		        		
		        		$obj['series'][$i]['data'][]= (int)$arr['count'];
		        		$obj['total'] += (int)$arr['count'];   
		    		}					
				}				
			$i++;
			}
			$obj['label']=$data_gender;
			$obj['xlabel']='Gender';

			$i=0;					
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";			
			$obj['html']=$obj['html']."<tr><th>Gender</th>";				
			for($k=0;$k<count($data_gender);$k++){
				$obj['html']=$obj['html']."<th>".$data_gender[$k]."</th>";				        
			}						
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";				
				foreach ($data_gender as $gender) {			       									       
					$results= $em->getRepository('AppBundle\Entity\Query')->getGenderFilteredArray($data_question,$ans,$gender,$data_disability,$data_year);
					foreach ($results as $arr){		        		
			    		$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";
			    		$obj['total'] += (int)$arr['count'];  
	    			}	
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}
		


		//Only ethnicity filter selected(5.E)
		if(isset($data_ethnicity) && !isset($data_age) && !isset($data_gender) && !isset($data_district) && !isset($data_month)){
			$i=0;
			$obj['stack']='normal';	//For stack chart
			foreach ($obj['answer'] as $num){	
				$obj['series'][$i]['name']= $num;  //Alternative to array_push
				foreach ($data_ethnicity as $ethnicity){
					$results= $em->getRepository('AppBundle\Entity\Query')->getEthnicityFilteredArray($data_question,$num,$ethnicity,$data_disability,$data_year);
					foreach ($results as $arr){		        		
		        		$obj['series'][$i]['data'][]= (int)$arr['count'];  
		        		$obj['total'] += (int)$arr['count']; 
		    		}					
				}				
			$i++;
			}
			$obj['label']=$data_ethnicity;
			$obj['xlabel']='Ethnicity';
			
			$i=0;					
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";			
			$obj['html']=$obj['html']."<tr><th>Ethnicity</th>";				
			for($k=0;$k<count($data_ethnicity);$k++){
				$obj['html']=$obj['html']."<th>".$data_ethnicity[$k]."</th>";				        
			}						
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";				
				foreach ($data_ethnicity as $ethnicity) {			       									       
					$results= $em->getRepository('AppBundle\Entity\Query')->getEthnicityFilteredArray($data_question,$ans,$ethnicity,$data_disability,$data_year);
					foreach ($results as $arr){		        		
			    		$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";
			    		$obj['total'] += (int)$arr['count'];  
	    			}	
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";			

		}


		//Only age filter selected(6.A)
		if(isset($data_age) && !isset($data_gender) && !isset($data_ethnicity) && !isset($data_district) && !isset($data_month)){
			$i=0;
			$obj['stack']='normal'; //For stack chart
			foreach ($obj['answer'] as $num){	
				$obj['series'][$i]['name']= $num;  //Alternative to array_push
				foreach ($data_age as $age){
					$results= $em->getRepository('AppBundle\Entity\Query')->getAgeFilteredArray($data_question,$num,$age,$data_disability,$data_year);
					foreach ($results as $arr){		        		
		        		$obj['series'][$i]['data'][]= (int)$arr['count']; 
		        		$obj['total'] += (int)$arr['count'];  
		    		}					
				}				
			$i++;
			}
			$obj['label']=$data_age;
			$obj['xlabel']='Age';
			
			$i=0;					
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";			
			$obj['html']=$obj['html']."<tr><th>Age</th>";				
			for($k=0;$k<count($data_age);$k++){
				$obj['html']=$obj['html']."<th>".$data_age[$k]."</th>";				        
			}						
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";				
				foreach ($data_age as $age) {			       									       
					$results= $em->getRepository('AppBundle\Entity\Query')->getAgeFilteredArray($data_question,$ans,$age,$data_disability,$data_year);
					foreach ($results as $arr){		        		
			    		$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";
			    		$obj['total'] += (int)$arr['count'];  
	    			}	
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}
		//Month and District filter selected(7.MD)
		if(!isset($data_ethnicity) && !isset($data_gender) && !isset($data_age) && isset($data_district) && isset($data_month)){
			// $i=0;
			// $flag=0; // For hiding legend of grouped columns with same name
			// $obj['stack']='normal'; //For stack chart
			// foreach ($data_month as $month) {					
			// 	$j=0;				
			// 	foreach ($obj['answer'] as $num){	
			// 		$obj['series'][$i]['name']= $num;
			// 		if($flag==0){						
			// 			$obj['series'][$i]['id']= $num; 
			// 		}
			// 		$obj['series'][$i]['stack']=$month;
			// 		$obj['series'][$i]['color']=$colors[$j];//For making the color same on different stacks of grouped columns
			// 		if($flag>0){
			// 			//$obj['series'][$i]['showInLegend'] = (int)0;
			// 			$obj['series'][$i]['name']= $num;
			// 			$obj['series'][$i]['linkedTo'] = $num;						
			// 		}
			// 		foreach ($data_district as $district){				
			// 			$results= $em->getRepository('AppBundle\Entity\Query')->getMonthDistrict($data_question,$num,$district,$month,$data_disability,$data_year);
			// 			foreach ($results as $arr){		        		
			//         		$obj['series'][$i]['data'][]= (int)$arr['count'];
			//         		$obj['total'] += (int)$arr['count'];   
			//     		}					
			// 		}				
			// 		$i++;
			// 		$j++;
			// 	}
			// 	$flag++;				
				

			// }
			// $obj['label']=$data_district;
			// $obj['xlabel']='District';

			$i=0;			
			$district_span=count($data_month);				
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>District</th>";
			for($j=0;$j<count($data_district);$j++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Month</th>";			
			for($i=0;$i<count($data_district);$i++){	
				for($k=0;$k<count($data_month);$k++){
					$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
				}
			}			
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_district as $district) {					
					foreach ($data_month as $month) {			       									       
						$results= $em->getRepository('AppBundle\Entity\Query')->getMonthDistrict($data_question,$ans,$district,$month,$data_disability,$data_year);
						foreach ($results as $arr){		        		
			       			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>"; 

			    		}	
					}					
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

		//Month and Gender filter selected(8.MG)
		if(!isset($data_ethnicity) && isset($data_gender) && !isset($data_age) && !isset($data_district) && isset($data_month)){
			$i=0;
			$flag=0; // For hiding legend of grouped columns with same name
			$obj['stack']='normal'; //For stack chart
			if(count($data_gender)>1){
				$obj['grouped']='Grouped By Female/Male';
			}
			foreach ($data_gender as $gender) {				
				$j=0;				
				foreach ($obj['answer'] as $num){	
					$obj['series'][$i]['name']= $num;
					if($flag==0){						
						$obj['series'][$i]['id']= $num; 
					}
					$obj['series'][$i]['stack']=$gender;
					$obj['series'][$i]['color']=$colors[$j];//For making the color same on different stacks of grouped columns
					if($flag>0){										
						$obj['series'][$i]['linkedTo'] = $num;						
					}
					foreach ($data_month as $month){				
						$results= $em->getRepository('AppBundle\Entity\Query')->getMonthGender($data_question,$num,$month,$gender,$data_disability,$data_year);
						foreach ($results as $arr){		        		
			        		$obj['series'][$i]['data'][]= (int)$arr['count'];  
			        		$obj['total'] += (int)$arr['count']; 
			    		}					
					}				
					$i++;
					$j++;
				}
				$flag++;				
			}
			$obj['label']=$data_month;
			$obj['xlabel']='Month';
			$i=0;
			// foreach ($data_month as $month){
			// 	$obj['label'][$i]['name'][]=$month;
			// 	$obj['label'][$i]['categories'][]=$data_gender;
			// 	$i++;
			// }
			$i=0;			
			$month_span=count($data_gender);				
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>Month</th>";
			for($j=0;$j<count($data_month);$j++){
				$obj['html']=$obj['html']."<th colspan='".$month_span."'>".$data_month[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Gender</th>";			
			for($i=0;$i<count($data_month);$i++){	
				for($k=0;$k<count($data_gender);$k++){
					$obj['html']=$obj['html']."<th>".$data_gender[$k]."</th>";				        
				}
			}			
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_month as $month) {					
					foreach ($data_gender as $gender) {			       									       
						$results= $em->getRepository('AppBundle\Entity\Query')->getMonthGender($data_question,$num,$month,$gender,$data_disability,$data_year);
						foreach ($results as $arr){		        		
			       			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>"; 

			    		}	
					}					
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

		//Month and Ethnicity filter selected(9.ME)
		if(isset($data_ethnicity) && !isset($data_gender) && !isset($data_age) && !isset($data_district) && isset($data_month)){
			// $i=0;
			// $flag=0; // For hiding legend of grouped columns with same name
			// $obj['stack']='normal'; //For stack chart
			// foreach ($data_month as $month) {				
			// 	$j=0;				
			// 	foreach ($obj['answer'] as $num){	
			// 		$obj['series'][$i]['name']= $num;
			// 		if($flag==0){						
			// 			$obj['series'][$i]['id']= $num; 
			// 		}
			// 		$obj['series'][$i]['stack']=$month;
			// 		$obj['series'][$i]['color']=$colors[$j];//For making the color same on different stacks of grouped columns
			// 		if($flag>0){
			// 			//$obj['series'][$i]['showInLegend'] = (int)0;
			// 			$obj['series'][$i]['linkedTo'] = $num;						
			// 		}
			// 		foreach ($data_ethnicity as $ethnicity){				
			// 			$results= $em->getRepository('AppBundle\Entity\Query')->getMonthEthnicity($data_question,$num,$ethnicity,$month,$data_disability,$data_year);
			// 			foreach ($results as $arr){		        		
			//         		$obj['series'][$i]['data'][]= (int)$arr['count'];
			//         		$obj['total'] += (int)$arr['count'];   
			//     		}					
			// 		}				
			// 		$i++;
			// 		$j++;
			// 	}
			// 	$flag++;				
			// }
			// $obj['label']=$data_ethnicity;
			// $obj['xlabel']='Ethnicity';
			
			$i=0;			
			$ethnicity_span=count($data_month);				
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>Ethnicity</th>";
			for($j=0;$j<count($data_ethnicity);$j++){
				$obj['html']=$obj['html']."<th colspan='".$ethnicity_span."'>".$data_ethnicity[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Month</th>";			
			for($i=0;$i<count($data_ethnicity);$i++){	
				for($k=0;$k<count($data_month);$k++){
					$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
				}
			}			
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_ethnicity as $ethnicity) {					
					foreach ($data_month as $month) {			       									       
						$results= $em->getRepository('AppBundle\Entity\Query')->getMonthEthnicity($data_question,$ans,$ethnicity,$month,$data_disability,$data_year);
						foreach ($results as $arr){		        		
			       			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>"; 

			    		}	
					}					
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

		//Month and Age filter selected(10.MA)
		if(!isset($data_ethnicity) && !isset($data_gender) && isset($data_age) && !isset($data_district) && isset($data_month)){
			// $i=0;
			// $flag=0; // For hiding legend of grouped columns with same name
			// $obj['stack']='normal'; //For stack chart
			// foreach ($data_month as $month) {				
			// 	$j=0;				
			// 	foreach ($obj['answer'] as $num){	
			// 		$obj['series'][$i]['name']= $num;
			// 		if($flag==0){						
			// 			$obj['series'][$i]['id']= $num; 
			// 		}
			// 		$obj['series'][$i]['stack']=$month;
			// 		$obj['series'][$i]['color']=$colors[$j];//For making the color same on different stacks of grouped columns
			// 		if($flag>0){
			// 			//$obj['series'][$i]['showInLegend'] = (int)0;
			// 			$obj['series'][$i]['linkedTo'] = $num;						
			// 		}
			// 		foreach ($data_age as $age){				
			// 			$results= $em->getRepository('AppBundle\Entity\Query')->getMonthAge($data_question,$num,$age,$month,$data_disability,$data_year);
			// 			foreach ($results as $arr){		        		
			//         		$obj['series'][$i]['data'][]= (int)$arr['count']; 
			//         		$obj['total'] += (int)$arr['count'];  
			//     		}					
			// 		}				
			// 		$i++;
			// 		$j++;
			// 	}
			// 	$flag++;				
			// }
			// $obj['label']=$data_age;
			// $obj['xlabel']='Age';

			$i=0;			
			$age_span=count($data_month);				
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>Age</th>";
			for($j=0;$j<count($data_age);$j++){
				$obj['html']=$obj['html']."<th colspan='".$age_span."'>".$data_age[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Month</th>";			
			for($i=0;$i<count($data_age);$i++){	
				for($k=0;$k<count($data_month);$k++){
					$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
				}
			}			
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_age as $age) {					
					foreach ($data_month as $month) {			       									       
						$results= $em->getRepository('AppBundle\Entity\Query')->getMonthAge($data_question,$ans,$age,$month,$data_disability,$data_year);
						foreach ($results as $arr){		        		
			       			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>"; 

			    		}	
					}					
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

		//District and Gender filter selected(11.DG)
		if(!isset($data_ethnicity) && isset($data_gender) && !isset($data_age) && isset($data_district) && !isset($data_month)){
			$i=0;
			$flag=0; // For hiding legend of grouped columns with same name
			$obj['stack']='normal'; //For stack chart
			if(count($data_gender)>1){
				$obj['grouped']='Grouped By Female/Male';
			}
			foreach ($data_gender as $gender) {				
				$j=0;				
				foreach ($obj['answer'] as $num){	
					$obj['series'][$i]['name']= $num;
					if($flag==0){						
						$obj['series'][$i]['id']= $num; 
					}
					$obj['series'][$i]['stack']=$gender;
					$obj['series'][$i]['color']=$colors[$j];//For making the color same on different stacks of grouped columns
					if($flag>0){										
						$obj['series'][$i]['linkedTo'] = $num;						
					}
					foreach ($data_district as $district){				
						$results= $em->getRepository('AppBundle\Entity\Query')->getDistrictGender($data_question,$num,$district,$gender,$data_disability,$data_year);
						foreach ($results as $arr){		        		
			        		$obj['series'][$i]['data'][]= (int)$arr['count'];
			        		$obj['total'] += (int)$arr['count']; 
			    		}					
					}				
					$i++;
					$j++;
				}
				$flag++;				
			}
			$obj['label']=$data_district;
			$obj['xlabel']='District';
		}

		//Ethnicity,District Filter selected(12.DE)
		if(isset($data_ethnicity) && !isset($data_gender) && !isset($data_age) && isset($data_district) && !isset($data_month)){
			$i=0;			
			$district_span=count($data_ethnicity);				
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>District</th>";
			for($j=0;$j<count($data_district);$j++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Ethnicity</th>";			
			for($i=0;$i<count($data_district);$i++){	
				for($k=0;$k<count($data_ethnicity);$k++){
					$obj['html']=$obj['html']."<th>".$data_ethnicity[$k]."</th>";				        
				}
			}			
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_district as $district) {					
					foreach ($data_ethnicity as $ethnicity) {			       									       
						$results= $em->getRepository('AppBundle\Entity\Query')->getDistrictEthnicity($data_question,$ans,$district,$ethnicity,$data_disability,$data_year);
						foreach ($results as $arr){		        		
			       			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>"; 

			    		}	
					}					
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

		//Age,District Filter selected(13.DA)
		if(!isset($data_ethnicity) && !isset($data_gender) && isset($data_age) && isset($data_district) && !isset($data_month)){
			$i=0;			
			$district_span=count($data_age);				
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>District</th>";
			for($j=0;$j<count($data_district);$j++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Age</th>";			
			for($i=0;$i<count($data_district);$i++){	
				for($k=0;$k<count($data_age);$k++){
					$obj['html']=$obj['html']."<th>".$data_age[$k]."</th>";				        
				}
			}			
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_district as $district) {					
					foreach ($data_age as $age) {			       									       
						$results= $em->getRepository('AppBundle\Entity\Query')->getDistrictAge($data_question,$ans,$district,$age,$data_disability,$data_year);
						foreach ($results as $arr){		        		
			       			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>"; 
			       			$obj['total'] += (int)$arr['count'];
			    		}	
					}					
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}





		//Gender and Ethnicity filter selected(14.GE)
		if(isset($data_ethnicity) && isset($data_gender) && !isset($data_age) && !isset($data_district) && !isset($data_month)){
			$i=0;
			$flag=0; // For hiding legend of grouped columns with same name
			$obj['stack']='normal'; //For stack chart
			if(count($data_gender)>1){
				$obj['grouped']='Grouped By Female/Male';
			}
			foreach ($data_gender as $gender) {	
				$j=0;			
				foreach ($obj['answer'] as $num){	
					$obj['series'][$i]['name']= $num;
					if($flag==0){						
						$obj['series'][$i]['id']= $num; 
					}
					$obj['series'][$i]['stack']=$gender;
					$obj['series'][$i]['color']=$colors[$j];//For making the color same on different stacks of grouped columns
					if($flag>0){						
						$obj['series'][$i]['linkedTo'] = $num;						
					}
					foreach ($data_ethnicity as $ethnicity){				
						$results= $em->getRepository('AppBundle\Entity\Query')->getEthnicityGender($data_question,$num,$ethnicity,$gender,$data_disability,$data_year);
						foreach ($results as $arr){		        		
			        		$obj['series'][$i]['data'][]= (int)$arr['count'];
			        		$obj['total'] += (int)$arr['count'];   
			    		}								
					}				
					$i++;
					$j++;
				}				
				$flag++;
			}
			$obj['label']=$data_ethnicity;
			$obj['xlabel']='Ethnicity';
		}
		
		//Age and Gender filter selected(15.GA)
		if(isset($data_age) && isset($data_gender) && !isset($data_ethnicity) && !isset($data_district) && !isset($data_month)){
			$i=0;
			$obj['stack']='normal'; //For stack chart
			if(count($data_gender)>1){
				$obj['grouped']='Grouped By Female/Male';
			}
			foreach ($data_gender as $gender) {				
				$j=0;
				foreach ($obj['answer'] as $num){					
					$obj['series'][$i]['name']= $num;
					if($flag==0){						
						$obj['series'][$i]['id']= $num; 
					}  
					$obj['series'][$i]['stack']=$gender;
					$obj['series'][$i]['color']=$colors[$j];//For making the color same on different stacks of grouped columns
					if($flag>0){
						$obj['series'][$i]['linkedTo'] = $num;						
					}
					foreach ($data_age as $age){				
						$results= $em->getRepository('AppBundle\Entity\Query')->getAgeGender($data_question,$num,$age,$gender,$data_disability,$data_year);
						foreach ($results as $arr){		        		
			        		$obj['series'][$i]['data'][]= (int)$arr['count'];   //Alternative to array_push
			        		$obj['total'] += (int)$arr['count'];
			    		}						
					}				
					$i++;
					$j++;
				}
				$flag++;				
			}
			$obj['label']=$data_age;
			$obj['xlabel']='Age';
		}

		//Ethnicity,District Filter selected(16.EA)
		if(isset($data_ethnicity) && !isset($data_gender) && isset($data_age) && !isset($data_district) && !isset($data_month)){
			$i=0;			
			$ethnicity_span=count($data_age);				
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>Ethnicity</th>";
			for($j=0;$j<count($data_ethnicity);$j++){
				$obj['html']=$obj['html']."<th colspan='".$ethnicity_span."'>".$data_ethnicity[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Age</th>";			
			for($i=0;$i<count($data_ethnicity);$i++){	
				for($k=0;$k<count($data_age);$k++){
					$obj['html']=$obj['html']."<th>".$data_age[$k]."</th>";				        
				}
			}			
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_ethnicity as $ethnicity) {					
					foreach ($data_age as $age) {			       									       
						$results= $em->getRepository('AppBundle\Entity\Query')->getEthnicityAge($data_question,$ans,$ethnicity,$age,$data_disability,$data_year);
						foreach ($results as $arr){		        		
			       			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>"; 
			       			$obj['total'] += (int)$arr['count'];  
			    		}	
					}					
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}
		//Gender,Month,District Filter selected(17.MDG->DGM)
		if(!isset($data_ethnicity) && isset($data_gender) && !isset($data_age) && isset($data_district) && isset($data_month)){
			$i=0;
			if(count($data_gender)>1){
				$district_span=count($data_month)*count($data_gender);
			}
			else{
				$district_span=count($data_month);
			}
			$gender_span=count($data_month);			
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>District</th>";
			for($j=0;$j<count($data_district);$j++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Gender</th>";
			for($j=0;$j<count($data_district);$j++){
				for($k=0;$k<count($data_gender);$k++){
					$obj['html']=$obj['html']."<th colspan='".$gender_span."'>".$data_gender[$k]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Month</th>";				
			for($i=0;$i<count($data_district);$i++){
				for($j=0;$j<count($data_gender);$j++){
					for($k=0;$k<count($data_month);$k++){
						$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
					}
				}
			}			
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_district as $district) {
					foreach ($data_gender as $gender) {
						foreach ($data_month as $month) {			       									       
							$results= $em->getRepository('AppBundle\Entity\Query')->getMonthDistrictGender($data_question,$ans,$district,$month,$gender,$data_disability,$data_year);
							foreach ($results as $arr){		        		
			        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";
			        			$obj['total'] += (int)$arr['count'];  

			    			}	
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}


		//Ethnicity,Month,District Filter selected(18.MDE->DEM)
		if(isset($data_ethnicity) && !isset($data_gender) && !isset($data_age) && isset($data_district) && isset($data_month)){
			$i=0;
			if(count($data_ethnicity)>1){
				$district_span=count($data_month)*count($data_ethnicity);
			}
			else{
				$district_span=count($data_month);
			}
			$ethnicity_span=count($data_month);			
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>District</th>";
			for($j=0;$j<count($data_district);$j++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Ethnicity</th>";
			for($j=0;$j<count($data_district);$j++){
				for($k=0;$k<count($data_ethnicity);$k++){
					$obj['html']=$obj['html']."<th colspan='".$ethnicity_span."'>".$data_ethnicity[$k]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Month</th>";				
			for($i=0;$i<count($data_district);$i++){
				for($j=0;$j<count($data_ethnicity);$j++){
					for($k=0;$k<count($data_month);$k++){
						$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
					}
				}
			}			
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_district as $district) {
					foreach ($data_ethnicity as $ethnicity) {
						foreach ($data_month as $month) {			       									       
							$results= $em->getRepository('AppBundle\Entity\Query')->getMonthDistrictEthnicity($data_question,$ans,$district,$month,$ethnicity,$data_disability,$data_year);
							foreach ($results as $arr){		        		
			        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";
			        			$obj['total'] += (int)$arr['count'];  

			    			}	
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}


		//Ethnicity,Month,District Filter selected(19.MDA->DAM)
		if(!isset($data_ethnicity) && !isset($data_gender) && isset($data_age) && isset($data_district) && isset($data_month)){
			$i=0;
			if(count($data_age)>1){
				$district_span=count($data_month)*count($data_age);
			}
			else{
				$district_span=count($data_month);
			}
			$age_span=count($data_month);			
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>District</th>";
			for($j=0;$j<count($data_district);$j++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Age</th>";
			for($j=0;$j<count($data_district);$j++){
				for($k=0;$k<count($data_age);$k++){
					$obj['html']=$obj['html']."<th colspan='".$age_span."'>".$data_age[$k]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Month</th>";					
			for($i=0;$i<count($data_district);$i++){
				for($j=0;$j<count($data_age);$j++){
					for($k=0;$k<count($data_month);$k++){
						$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
					}
				}
			}			
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_district as $district) {
					foreach ($data_age as $age) {
						foreach ($data_month as $month) {			       									       
							$results= $em->getRepository('AppBundle\Entity\Query')->getMonthDistrictAge($data_question,$ans,$district,$month,$age,$data_disability,$data_year);
							foreach ($results as $arr){		        		
			        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";  
			        			$obj['total'] += (int)$arr['count'];   
			    			}	
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

		//Month,Gender,Ethnicity Filter selected(20.MGE->EGM)
		if(isset($data_ethnicity) && isset($data_gender) && !isset($data_age) && !isset($data_district) && isset($data_month)){
			$i=0;
			if(count($data_gender)>1){
				$ethnicity_span=count($data_month)*count($data_gender);
			}
			else{
				$ethnicity_span=count($data_month);
			}
			$gender_span=count($data_month);			
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>Ethnicity</th>";
			for($j=0;$j<count($data_ethnicity);$j++){
				$obj['html']=$obj['html']."<th colspan='".$ethnicity_span."'>".$data_ethnicity[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Gender</th>";
			for($j=0;$j<count($data_ethnicity);$j++){
				for($k=0;$k<count($data_gender);$k++){
					$obj['html']=$obj['html']."<th colspan='".$gender_span."'>".$data_gender[$k]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Month</th>";
			if(count($data_gender)>1){				
				for($i=0;$i<count($data_ethnicity);$i++){
					for($j=0;$j<count($data_gender);$j++){
						for($k=0;$k<count($data_month);$k++){
							$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
						}
					}
				}
			}
			else{
				for($i=0;$i<count($data_ethnicity);$i++){	
					for($k=0;$k<count($data_month);$k++){
						$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
					}
				}
			}
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_ethnicity as $ethnicity) {
					foreach ($data_gender as $gender) {
						foreach ($data_month as $month) {			       									       
							$results= $em->getRepository('AppBundle\Entity\Query')->getMonthGenderEthnicity($data_question,$ans,$ethnicity,$gender,$month,$data_disability,$data_year);
							foreach ($results as $arr){		        		
			        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";  
			        			$obj['total'] += (int)$arr['count'];   
			    			}	
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

		//Month,Gender,Age Filter selected(21.MGA->AGM)
		if(!isset($data_ethnicity) && isset($data_gender) && isset($data_age) && !isset($data_district) && isset($data_month)){
			$i=0;
			if(count($data_gender)>1){
				$age_span=count($data_month)*count($data_gender);
			}
			else{
				$age_span=count($data_month);
			}
			$gender_span=count($data_month);			
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>Age</th>";
			for($j=0;$j<count($data_age);$j++){
				$obj['html']=$obj['html']."<th colspan='".$age_span."'>".$data_age[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Gender</th>";
			for($j=0;$j<count($data_age);$j++){
				for($k=0;$k<count($data_gender);$k++){
					$obj['html']=$obj['html']."<th colspan='".$gender_span."'>".$data_gender[$k]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Month</th>";
			if(count($data_gender)>1){				
				for($i=0;$i<count($data_age);$i++){
					for($j=0;$j<count($data_gender);$j++){
						for($k=0;$k<count($data_month);$k++){
							$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
						}
					}
				}
			}
			else{
				for($i=0;$i<count($data_age);$i++){	
					for($k=0;$k<count($data_month);$k++){
						$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
					}
				}
			}
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_age as $age) {
					foreach ($data_gender as $gender) {
						foreach ($data_month as $month) {			       									       
							$results= $em->getRepository('AppBundle\Entity\Query')->getMonthGenderAge($data_question,$ans,$age,$gender,$month,$data_disability,$data_year);
							foreach ($results as $arr){		        		
			        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>"; 
			        			$obj['total'] += (int)$arr['count'];    
			    			}	
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}
		//Month,Ethnicity,Age Filter selected(22.MEA->EMA)
		if(isset($data_ethnicity) && !isset($data_gender) && isset($data_age) && !isset($data_district) && isset($data_month)){
			$i=0;
			if(count($data_month)>1){
				$ethnicity_span=count($data_age)*count($data_month);
			}
			else{
				$ethnicity_span=count($data_age);
			}
			$month_span=count($data_age);			
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>Ethnicity</th>";
			for($j=0;$j<count($data_ethnicity);$j++){
				$obj['html']=$obj['html']."<th colspan='".$ethnicity_span."'>".$data_ethnicity[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Month</th>";
			for($j=0;$j<count($data_ethnicity);$j++){
				for($k=0;$k<count($data_month);$k++){
					$obj['html']=$obj['html']."<th colspan='".$month_span."'>".$data_month[$k]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Age</th>";						
			for($i=0;$i<count($data_ethnicity);$i++){
				for($j=0;$j<count($data_month);$j++){
					for($k=0;$k<count($data_age);$k++){
						$obj['html']=$obj['html']."<th>".$data_age[$k]."</th>";				        
					}
				}
			}			
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_ethnicity as $ethnicity) {
					foreach ($data_month as $month) {
						foreach ($data_age as $age) {			       									       
							$results= $em->getRepository('AppBundle\Entity\Query')->getMonthEthnicityAge($data_question,$ans,$ethnicity,$month,$age,$data_disability,$data_year);
							foreach ($results as $arr){		        		
			        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>"; 
			        			$obj['total'] += (int)$arr['count'];    
			    			}	
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

		//Ethnicity,Gender,District Filter selected(23.DGE->DEG)
		if(isset($data_ethnicity) && isset($data_gender) && !isset($data_age) && isset($data_district) && !isset($data_month)){
			$i=0;
			if(count($data_ethnicity)>1){
				$district_span=count($data_gender)*count($data_ethnicity);
			}
			else{
				$district_span=count($data_gender);
			}
			$ethnicity_span=count($data_gender);			
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>District</th>";
			for($j=0;$j<count($data_district);$j++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Ethnicity</th>";
			for($j=0;$j<count($data_district);$j++){
				for($k=0;$k<count($data_ethnicity);$k++){
					$obj['html']=$obj['html']."<th colspan='".$ethnicity_span."'>".$data_ethnicity[$k]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Gender</th>";
			for($i=0;$i<count($data_district);$i++){
				for($j=0;$j<count($data_ethnicity);$j++){
					for($k=0;$k<count($data_gender);$k++){
						$obj['html']=$obj['html']."<th>".$data_gender[$k]."</th>";				        
					}
				}
			}			
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_district as $district) {
					foreach ($data_ethnicity as $ethnicity) {
						foreach ($data_gender as $gender) {			       									       
							$results= $em->getRepository('AppBundle\Entity\Query')->getEthnicityDistrictGender($data_question,$ans,$district,$gender,$ethnicity,$data_disability,$data_year);
							foreach ($results as $arr){		        		
			        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";  
			        			$obj['total'] += (int)$arr['count'];   
			    			}	
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}


		//Age,Gender,District,Ethnicity Filter selected(24.DGA->DAG)
		if(!isset($data_ethnicity) && isset($data_gender) && isset($data_age) && isset($data_district) && !isset($data_month)){
			$i=0;
			if(count($data_age)>1){
				$district_span=count($data_gender)*count($data_age);
			}
			else{
				$district_span=count($data_gender);
			}
			$age_span=count($data_gender);			
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>District</th>";
			for($j=0;$j<count($data_district);$j++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Age</th>";
			for($j=0;$j<count($data_district);$j++){
				for($k=0;$k<count($data_age);$k++){
					$obj['html']=$obj['html']."<th colspan='".$age_span."'>".$data_age[$k]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Gender</th>";
			for($i=0;$i<count($data_district);$i++){
				for($j=0;$j<count($data_age);$j++){
					for($k=0;$k<count($data_gender);$k++){
						$obj['html']=$obj['html']."<th>".$data_gender[$k]."</th>";				        
					}
				}
			}			
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_district as $district) {
					foreach ($data_age as $age) {
						foreach ($data_gender as $gender) {			       									       
							$results= $em->getRepository('AppBundle\Entity\Query')->getAgeDistrictGender($data_question,$ans,$district,$gender,$age,$data_disability,$data_year);
							foreach ($results as $arr){		        		
			        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";  
			        			$obj['total'] += (int)$arr['count'];   
			    			}	
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

		//District,Ethnicity,Age Filter selected(25.DEA->DEA)
		if(isset($data_ethnicity) && !isset($data_gender) && isset($data_age) && isset($data_district) && !isset($data_month)){
			$i=0;
			if(count($data_ethnicity)>1){
				$district_span=count($data_age)*count($data_ethnicity);
			}
			else{
				$district_span=count($data_age);
			}
			$ethnicity_span=count($data_age);
			$obj['stack']='normal'; //For stack chart
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>District</th>";
			for($j=0;$j<count($data_district);$j++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Ethnicity</th>";
			for($j=0;$j<count($data_district);$j++){
				for($k=0;$k<count($data_ethnicity);$k++){
					$obj['html']=$obj['html']."<th colspan='".$ethnicity_span."'>".$data_ethnicity[$k]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Age Group</th>";
			for($i=0;$i<count($data_district);$i++){
				for($j=0;$j<count($data_ethnicity);$j++){
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
					foreach ($data_ethnicity as $ethnicity) {
						foreach ($data_age as $age) {			       									       
							$results= $em->getRepository('AppBundle\Entity\Query')->getDistrictEthnicityAge($data_question,$ans,$district,$ethnicity,$age,$data_disability,$data_year);
							foreach ($results as $arr){		        		
			        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>"; 
			        			$obj['total'] += (int)$arr['count'];    
			    			}	
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}
		//Ethnicity,Gender,Age,Ethnicity Filter selected(26.GEA->EAG)
		if(isset($data_ethnicity) && isset($data_gender) && isset($data_age) && !isset($data_district) && !isset($data_month)){
			$i=0;
			if(count($data_age)>1){
				$ethnicity_span=count($data_gender)*count($data_age);
			}
			else{
				$ethnicity_span=count($data_gender);
			}
			$age_span=count($data_gender);			
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>Ethnicity</th>";
			for($j=0;$j<count($data_ethnicity);$j++){
				$obj['html']=$obj['html']."<th colspan='".$ethnicity_span."'>".$data_ethnicity[$j]."</th>";
			}
			
			$obj['html']=$obj['html']."</tr><tr><th>Age</th>";
			for($j=0;$j<count($data_ethnicity);$j++){
				for($k=0;$k<count($data_age);$k++){
					$obj['html']=$obj['html']."<th colspan='".$age_span."'>".$data_age[$k]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Gender</th>";
			for($i=0;$i<count($data_ethnicity);$i++){
				for($j=0;$j<count($data_age);$j++){
					for($k=0;$k<count($data_gender);$k++){
						$obj['html']=$obj['html']."<th>".$data_gender[$k]."</th>";				        
					}
				}
			}			
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_ethnicity as $ethnicity) {
					foreach ($data_age as $age) {
						foreach ($data_gender as $gender) {			       									       
							$results= $em->getRepository('AppBundle\Entity\Query')->getAgeEthnicityGender($data_question,$ans,$ethnicity,$gender,$age,$data_disability,$data_year);
							foreach ($results as $arr){		        		
			        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";  
			        			$obj['total'] += (int)$arr['count'];   
			    			}	
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}
		

		//District,Month,Gender,Ethnicity Filter selected(27.MDGE->DEGM)
		if(isset($data_ethnicity) && isset($data_gender) && !isset($data_age) && isset($data_district) && isset($data_month)){
			$i=0;
			if(count($data_gender)>1){
				$ethnicity_span=count($data_month)*count($data_gender);
			}
			else{
				$ethnicity_span=count($data_month);
			}
			$district_span=$ethnicity_span*count($data_ethnicity);
			$gender_span=count($data_month);			
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>District</th>";
			for($j=0;$j<count($data_district);$j++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$j]."</th>";
			}
			$obj['html']=$obj['html']."</tr><tr><th>Ethnicity</th>";
			for($i=0;$i<count($data_district);$i++){
				for($j=0;$j<count($data_ethnicity);$j++){
					$obj['html']=$obj['html']."<th colspan='".$ethnicity_span."'>".$data_ethnicity[$j]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Gender</th>";
			for($i=0;$i<count($data_district);$i++){
				for($j=0;$j<count($data_ethnicity);$j++){
					for($k=0;$k<count($data_gender);$k++){
						$obj['html']=$obj['html']."<th colspan='".$gender_span."'>".$data_gender[$k]."</th>";
					}
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Month</th>";
			for($h=0;$h<count($data_district);$h++){
				for($i=0;$i<count($data_ethnicity);$i++){
					for($j=0;$j<count($data_gender);$j++){
						for($k=0;$k<count($data_month);$k++){
							$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
						}
					}
				}			
			}
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_district as $district) {
					foreach ($data_ethnicity as $ethnicity) {
						foreach ($data_gender as $gender) {
							foreach ($data_month as $month) {			       									       
								$results= $em->getRepository('AppBundle\Entity\Query')->getMDGE($data_question,$ans,$ethnicity,$gender,$month,$district,$data_disability,$data_year);
								foreach ($results as $arr){		        		
				        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";  
				        			$obj['total'] += (int)$arr['count'];   
				    			}	
							}
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

		//District,Month,Gender,Age Filter selected(28.MDGA->DAGM)
		if(!isset($data_ethnicity) && isset($data_gender) && isset($data_age) && isset($data_district) && isset($data_month)){
			$i=0;
			if(count($data_gender)>1){
				$age_span=count($data_month)*count($data_gender);
			}
			else{
				$age_span=count($data_month);
			}
			$district_span=$age_span*count($data_age);
			$gender_span=count($data_month);			
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>District</th>";
			for($j=0;$j<count($data_district);$j++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$j]."</th>";
			}
			$obj['html']=$obj['html']."</tr><tr><th>Age</th>";
			for($i=0;$i<count($data_district);$i++){
				for($j=0;$j<count($data_age);$j++){
					$obj['html']=$obj['html']."<th colspan='".$age_span."'>".$data_age[$j]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Gender</th>";
			for($i=0;$i<count($data_district);$i++){
				for($j=0;$j<count($data_age);$j++){
					for($k=0;$k<count($data_gender);$k++){
						$obj['html']=$obj['html']."<th colspan='".$gender_span."'>".$data_gender[$k]."</th>";
					}
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Month</th>";
			for($h=0;$h<count($data_district);$h++){
				for($i=0;$i<count($data_age);$i++){
					for($j=0;$j<count($data_gender);$j++){
						for($k=0;$k<count($data_month);$k++){
							$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
						}
					}
				}			
			}
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_district as $district) {
					foreach ($data_age as $age) {
						foreach ($data_gender as $gender) {
							foreach ($data_month as $month) {			       									       
								$results= $em->getRepository('AppBundle\Entity\Query')->getMDGA($data_question,$ans,$age,$gender,$month,$district,$data_disability,$data_year);
								foreach ($results as $arr){		        		
				        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";  
				        			$obj['total'] += (int)$arr['count'];   
				    			}	
							}
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

		//Ethnicity,Month,Gender,Age Filter selected(29.MGEA->EAGM)
		if(isset($data_ethnicity) && isset($data_gender) && isset($data_age) && !isset($data_district) && isset($data_month)){
			$i=0;
			if(count($data_gender)>1){
				$age_span=count($data_month)*count($data_gender);
			}
			else{
				$age_span=count($data_month);
			}
			$ethnicity_span=$age_span*count($data_age);
			$gender_span=count($data_month);			
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>Ethnicity</th>";
			for($j=0;$j<count($data_ethnicity);$j++){
				$obj['html']=$obj['html']."<th colspan='".$ethnicity_span."'>".$data_ethnicity[$j]."</th>";
			}
			$obj['html']=$obj['html']."</tr><tr><th>Age</th>";
			for($i=0;$i<count($data_ethnicity);$i++){
				for($j=0;$j<count($data_age);$j++){
					$obj['html']=$obj['html']."<th colspan='".$age_span."'>".$data_age[$j]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Gender</th>";
			for($i=0;$i<count($data_ethnicity);$i++){
				for($j=0;$j<count($data_age);$j++){
					for($k=0;$k<count($data_gender);$k++){
						$obj['html']=$obj['html']."<th colspan='".$gender_span."'>".$data_gender[$k]."</th>";
					}
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Month</th>";
			for($h=0;$h<count($data_ethnicity);$h++){
				for($i=0;$i<count($data_age);$i++){
					for($j=0;$j<count($data_gender);$j++){
						for($k=0;$k<count($data_month);$k++){
							$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
						}
					}
				}			
			}
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_ethnicity as $ethnicity) {
					foreach ($data_age as $age) {
						foreach ($data_gender as $gender) {
							foreach ($data_month as $month) {			       									       
								$results= $em->getRepository('AppBundle\Entity\Query')->getMGEA($data_question,$ans,$age,$gender,$month,$ethnicity,$data_disability,$data_year);
								foreach ($results as $arr){		        		
				        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";  
				        			$obj['total'] += (int)$arr['count'];   
				    			}	
							}
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

		//District,Month,Age,Ethnicity Filter selected(30.MDEA->DEAM)
		if(isset($data_ethnicity) && !isset($data_gender) && isset($data_age) && isset($data_district) && isset($data_month)){
			$i=0;
			if(count($data_age)>1){
				$ethnicity_span=count($data_month)*count($data_age);
			}
			else{
				$ethnicity_span=count($data_month);
			}
			$district_span=$ethnicity_span*count($data_ethnicity);
			$age_span=count($data_month);			
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>District</th>";
			for($j=0;$j<count($data_district);$j++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$j]."</th>";
			}
			$obj['html']=$obj['html']."</tr><tr><th>Ethnicity</th>";
			for($i=0;$i<count($data_district);$i++){
				for($j=0;$j<count($data_ethnicity);$j++){
					$obj['html']=$obj['html']."<th colspan='".$ethnicity_span."'>".$data_ethnicity[$j]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Age</th>";
			for($i=0;$i<count($data_district);$i++){
				for($j=0;$j<count($data_ethnicity);$j++){
					for($k=0;$k<count($data_age);$k++){
						$obj['html']=$obj['html']."<th colspan='".$age_span."'>".$data_age[$k]."</th>";
					}
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Month</th>";
			for($h=0;$h<count($data_district);$h++){
				for($i=0;$i<count($data_ethnicity);$i++){
					for($j=0;$j<count($data_age);$j++){
						for($k=0;$k<count($data_month);$k++){
							$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
						}
					}
				}			
			}
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_district as $district) {
					foreach ($data_ethnicity as $ethnicity) {
						foreach ($data_age as $age) {
							foreach ($data_month as $month) {			       									       
								$results= $em->getRepository('AppBundle\Entity\Query')->getMDEA($data_question,$ans,$ethnicity,$age,$month,$district,$data_disability,$data_year);
								foreach ($results as $arr){		        		
				        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";  
				        			$obj['total'] += (int)$arr['count'];   
				    			}	
							}
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}

		//District,Gender,Age,Ethnicity Filter selected(31.DGEA->DEAG)
		if(isset($data_ethnicity) && isset($data_gender) && isset($data_age) && isset($data_district) && !isset($data_month)){
			$i=0;
			if(count($data_age)>1){
				$ethnicity_span=count($data_gender)*count($data_age);
			}
			else{
				$ethnicity_span=count($data_gender);
			}
			$district_span=$ethnicity_span*count($data_ethnicity);
			$age_span=count($data_gender);			
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>District</th>";
			for($j=0;$j<count($data_district);$j++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$j]."</th>";
			}
			$obj['html']=$obj['html']."</tr><tr><th>Ethnicity</th>";
			for($i=0;$i<count($data_district);$i++){
				for($j=0;$j<count($data_ethnicity);$j++){
					$obj['html']=$obj['html']."<th colspan='".$ethnicity_span."'>".$data_ethnicity[$j]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Age</th>";
			for($i=0;$i<count($data_district);$i++){
				for($j=0;$j<count($data_ethnicity);$j++){
					for($k=0;$k<count($data_age);$k++){
						$obj['html']=$obj['html']."<th colspan='".$age_span."'>".$data_age[$k]."</th>";
					}
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Gender</th>";
			for($h=0;$h<count($data_district);$h++){
				for($i=0;$i<count($data_ethnicity);$i++){
					for($j=0;$j<count($data_age);$j++){
						for($k=0;$k<count($data_gender);$k++){
							$obj['html']=$obj['html']."<th>".$data_gender[$k]."</th>";				        
						}
					}
				}			
			}
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_district as $district) {
					foreach ($data_ethnicity as $ethnicity) {
						foreach ($data_age as $age) {
							foreach ($data_gender as $gender) {			       									       
								$results= $em->getRepository('AppBundle\Entity\Query')->getDGEA($data_question,$ans,$ethnicity,$age,$gender,$district,$data_disability,$data_year);
								foreach ($results as $arr){		        		
				        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";  
				        			$obj['total'] += (int)$arr['count'];   
				    			}	
							}
						}
					}
				}
				$obj['html']=$obj['html']."</tr>";
			}
			$obj['html']=$obj['html']."</tbody></table>";
		}
		
		//District,Ethnicity,Month,Gender,Age Filter selected(32.MDGEA->DEAGM)
		if(isset($data_ethnicity) && isset($data_gender) && isset($data_age) && isset($data_district) && isset($data_month)){
			$i=0;
			if(count($data_gender)>1){
				$age_span=count($data_month)*count($data_gender);
			}
			else{
				$age_span=count($data_month);
			}
			
			$ethnicity_span=$age_span*count($data_age);
			$district_span=$ethnicity_span*count($data_ethnicity);
			$gender_span=count($data_month);			
			$obj['html']="<table id='' class='table table-bordered dataTables'><thead>";
			$obj['html']=$obj['html']."<tr><th>District</th>";
			for($i=0;$i<count($data_district);$i++){
				$obj['html']=$obj['html']."<th colspan='".$district_span."'>".$data_district[$i]."</th>";
			}
			$obj['html']=$obj['html']."</tr><tr><th>Ethnicity</th>";
			for($i=0;$i<count($data_district);$i++){
				for($j=0;$j<count($data_ethnicity);$j++){
					$obj['html']=$obj['html']."<th colspan='".$ethnicity_span."'>".$data_ethnicity[$j]."</th>";
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Age</th>";
			for($h=0;$h<count($data_district);$h++){
				for($i=0;$i<count($data_ethnicity);$i++){
					for($j=0;$j<count($data_age);$j++){
						$obj['html']=$obj['html']."<th colspan='".$age_span."'>".$data_age[$j]."</th>";
					}
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Gender</th>";
			for($h=0;$h<count($data_district);$h++){
				for($i=0;$i<count($data_ethnicity);$i++){
					for($j=0;$j<count($data_age);$j++){
						for($k=0;$k<count($data_gender);$k++){
							$obj['html']=$obj['html']."<th colspan='".$gender_span."'>".$data_gender[$k]."</th>";
						}
					}
				}
			}
			$obj['html']=$obj['html']."</tr><tr><th>Month</th>";
			for($g=0;$g<count($data_district);$g++){
				for($h=0;$h<count($data_ethnicity);$h++){
					for($i=0;$i<count($data_age);$i++){
						for($j=0;$j<count($data_gender);$j++){
							for($k=0;$k<count($data_month);$k++){
								$obj['html']=$obj['html']."<th>".$data_month[$k]."</th>";				        
							}
						}
					}			
				}
			}
			$obj['html']=$obj['html']."</tr></thead><tbody>";
			foreach ($obj['answer'] as $ans) {
				$obj['html']=$obj['html']."<tr><th>".$ans."</th>";
				foreach ($data_district as $district) {
					foreach ($data_ethnicity as $ethnicity) {
						foreach ($data_age as $age) {
							foreach ($data_gender as $gender) {
								foreach ($data_month as $month) {			       									       
									$results= $em->getRepository('AppBundle\Entity\Query')->getMDGEA($data_question,$ans,$age,$gender,$month,$ethnicity,$district,$data_disability,$data_year);
									foreach ($results as $arr){		        		
					        			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";  
					        			$obj['total'] += (int)$arr['count'];   
					    			}	
								}
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