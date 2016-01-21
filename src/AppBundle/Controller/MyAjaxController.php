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
		$data_month = $request->request->get('data_month');
		$colors=['#99bc44','#ff6600','#E23239','#349de7','#FFC33C','#159c02','#88d8ef','#588C73','#D96459','#B0A472','#333332','#D7D1CA','#EB65A0','#982395','#CDCDCD','#CD92BA','#DAFFA6','#85BACD','#B0A472','#D94E67',' #0241E2', '#F7F960'];
		//$data_question = 1;
		//$data_age = ['15 - 24','25 - 39','40 - 54'];
		// $data_gender= ['Male','Female'];
		//$data_ethnicity=['Brahmin','Chhetri','Dalit'];
		//$data_district=['Kathmandu','Dolakha'];
		//$data_month=['January','July','August','September'];
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
		    	$results = $em->getRepository('AppBundle\Entity\Query')->getBasicArray($data_question,$num);
			 	foreach ($results as $arr){
		        	//array_push($obj['count'], (int)$arr['count']);   
		    		$obj['series'][$i]['data'][]= (int)$arr['count'];
		    	}    	
		    	
		    	$obj['label']=$obj['answer'];
		    }			 
		}

		//Only Month filter selected(2.M)
		if(!isset($data_age) && !isset($data_gender) && !isset($data_ethnicity) && !isset($data_district) && isset($data_month)){
			$i=0;
			$obj['stack']='normal'; //For stack chart
			foreach ($obj['answer'] as $num){	
				$obj['series'][$i]['name']= $num;  //Alternative to array_push
				foreach ($data_month as $month){
					$results= $em->getRepository('AppBundle\Entity\Query')->getMonthFilteredArray($data_question,$num,$month);
					foreach ($results as $arr){		        		
		        		$obj['series'][$i]['data'][]= (int)$arr['count'];   
		    		}					
				}				
			$i++;
			}
			$obj['label']=$data_month;
			$obj['xlabel']='Month';//Set for category name on table created by highchart getTable() method
		}

		//Only District filter selected(3.D)
		if(!isset($data_age) && !isset($data_gender) && !isset($data_ethnicity) && isset($data_district) && !isset($data_month)){
			$i=0;
			$obj['stack']='normal'; //For stack chart
			foreach ($obj['answer'] as $num){	
				$obj['series'][$i]['name']= $num;  //Alternative to array_push
				foreach ($data_district as $district){
					$results= $em->getRepository('AppBundle\Entity\Query')->getDistrictFilteredArray($data_question,$num,$district);
					foreach ($results as $arr){		        		
		        		$obj['series'][$i]['data'][]= (int)$arr['count'];   
		    		}					
				}				
			$i++;
			}
			$obj['label']=$data_district;
			$obj['xlabel']='District';
		}

		//Only Gender filter selected(4.G)
		if(!isset($data_age) && isset($data_gender) && !isset($data_ethnicity) && !isset($data_district) && !isset($data_month)){
			$i=0;
			$obj['stack']='normal'; //For stack chart
			foreach ($obj['answer'] as $num){	
				$obj['series'][$i]['name']= $num;  //Alternative to array_push
				foreach ($data_gender as $gender){
					$results= $em->getRepository('AppBundle\Entity\Query')->getGenderFilteredArray($data_question,$num,$gender);
					foreach ($results as $arr){		        		
		        		$obj['series'][$i]['data'][]= (int)$arr['count'];   
		    		}					
				}				
			$i++;
			}
			$obj['label']=$data_gender;
			$obj['xlabel']='Gender';
		}


		//Only ethnicity filter selected(5.E)
		if(isset($data_ethnicity) && !isset($data_age) && !isset($data_gender) && !isset($data_district) && !isset($data_month)){
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
			$obj['xlabel']='Ethnicity';
		}


		//Only age filter selected(6.A)
		if(isset($data_age) && !isset($data_gender) && !isset($data_ethnicity) && !isset($data_district) && !isset($data_month)){
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
			$obj['xlabel']='Age';
		}
		//Month and District filter selected(7.MD)
		if(!isset($data_ethnicity) && !isset($data_gender) && !isset($data_age) && isset($data_district) && isset($data_month)){
			$i=0;
			$flag=0; // For hiding legend of grouped columns with same name
			$obj['stack']='normal'; //For stack chart
			foreach ($data_month as $month) {				
				$j=0;				
				foreach ($obj['answer'] as $num){	
					$obj['series'][$i]['name']= $num;
					if($flag==0){						
						$obj['series'][$i]['id']= $num; 
					}
					$obj['series'][$i]['stack']=$month;
					$obj['series'][$i]['color']=$colors[$j];//For making the color same on different stacks of grouped columns
					if($flag>0){
						//$obj['series'][$i]['showInLegend'] = (int)0;
						$obj['series'][$i]['name']= $num;
						$obj['series'][$i]['linkedTo'] = $num;						
					}
					foreach ($data_district as $district){				
						$results= $em->getRepository('AppBundle\Entity\Query')->getMonthDistrict($data_question,$num,$district,$month);
						foreach ($results as $arr){		        		
			        		$obj['series'][$i]['data'][]= (int)$arr['count'];   
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

		//Month and Gender filter selected(8.MG)
		if(!isset($data_ethnicity) && isset($data_gender) && !isset($data_age) && !isset($data_district) && isset($data_month)){
			$i=0;
			$flag=0; // For hiding legend of grouped columns with same name
			$obj['stack']='normal'; //For stack chart
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
						$results= $em->getRepository('AppBundle\Entity\Query')->getMonthGender($data_question,$num,$month,$gender);
						foreach ($results as $arr){		        		
			        		$obj['series'][$i]['data'][]= (int)$arr['count'];   
			    		}					
					}				
					$i++;
					$j++;
				}
				$flag++;				
			}
			$obj['label']=$data_month;
			$obj['xlabel']='Month';
		}

		//Month and Ethnicity filter selected(9.ME)
		if(isset($data_ethnicity) && !isset($data_gender) && !isset($data_age) && !isset($data_district) && isset($data_month)){
			$i=0;
			$flag=0; // For hiding legend of grouped columns with same name
			$obj['stack']='normal'; //For stack chart
			foreach ($data_month as $month) {				
				$j=0;				
				foreach ($obj['answer'] as $num){	
					$obj['series'][$i]['name']= $num;
					if($flag==0){						
						$obj['series'][$i]['id']= $num; 
					}
					$obj['series'][$i]['stack']=$month;
					$obj['series'][$i]['color']=$colors[$j];//For making the color same on different stacks of grouped columns
					if($flag>0){
						//$obj['series'][$i]['showInLegend'] = (int)0;
						$obj['series'][$i]['linkedTo'] = $num;						
					}
					foreach ($data_ethnicity as $ethnicity){				
						$results= $em->getRepository('AppBundle\Entity\Query')->getMonthEthnicity($data_question,$num,$ethnicity,$month);
						foreach ($results as $arr){		        		
			        		$obj['series'][$i]['data'][]= (int)$arr['count'];   
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

		//Month and Age filter selected(10.MA)
		if(!isset($data_ethnicity) && !isset($data_gender) && isset($data_age) && !isset($data_district) && isset($data_month)){
			$i=0;
			$flag=0; // For hiding legend of grouped columns with same name
			$obj['stack']='normal'; //For stack chart
			foreach ($data_month as $month) {				
				$j=0;				
				foreach ($obj['answer'] as $num){	
					$obj['series'][$i]['name']= $num;
					if($flag==0){						
						$obj['series'][$i]['id']= $num; 
					}
					$obj['series'][$i]['stack']=$month;
					$obj['series'][$i]['color']=$colors[$j];//For making the color same on different stacks of grouped columns
					if($flag>0){
						//$obj['series'][$i]['showInLegend'] = (int)0;
						$obj['series'][$i]['linkedTo'] = $num;						
					}
					foreach ($data_age as $age){				
						$results= $em->getRepository('AppBundle\Entity\Query')->getMonthAge($data_question,$num,$age,$month);
						foreach ($results as $arr){		        		
			        		$obj['series'][$i]['data'][]= (int)$arr['count'];   
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

		//District and Gender filter selected(11.DG)
		if(!isset($data_ethnicity) && isset($data_gender) && !isset($data_age) && isset($data_district) && !isset($data_month)){
			$i=0;
			$flag=0; // For hiding legend of grouped columns with same name
			$obj['stack']='normal'; //For stack chart
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
						$results= $em->getRepository('AppBundle\Entity\Query')->getDistrictGender($data_question,$num,$district,$gender);
						foreach ($results as $arr){		        		
			        		$obj['series'][$i]['data'][]= (int)$arr['count'];   
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
			$obj['html']="<table id='' class='table table-bordered'><thead>";
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
						$results= $em->getRepository('AppBundle\Entity\Query')->getDistrictEthnicity($data_question,$ans,$district,$ethnicity);
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
			$obj['html']="<table id='' class='table table-bordered'><thead>";
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
						$results= $em->getRepository('AppBundle\Entity\Query')->getDistrictAge($data_question,$ans,$district,$age);
						foreach ($results as $arr){		        		
			       			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";   
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
						$results= $em->getRepository('AppBundle\Entity\Query')->getEthnicityGender($data_question,$num,$ethnicity,$gender);
						foreach ($results as $arr){		        		
			        		$obj['series'][$i]['data'][]= (int)$arr['count'];   
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
						$results= $em->getRepository('AppBundle\Entity\Query')->getAgeGender($data_question,$num,$age,$gender);
						foreach ($results as $arr){		        		
			        		$obj['series'][$i]['data'][]= (int)$arr['count'];   //Alternative to array_push
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
			$obj['html']="<table id='' class='table table-bordered'><thead>";
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
						$results= $em->getRepository('AppBundle\Entity\Query')->getEthnicityAge($data_question,$ans,$ethnicity,$age);
						foreach ($results as $arr){		        		
			       			$obj['html']=$obj['html']."<td>".(int)$arr['count']."</td>";   
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
			$obj['html']="<table id='' class='table table-bordered'><thead>";
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
							$results= $em->getRepository('AppBundle\Entity\Query')->getMonthDistrictEthnicity($data_question,$ans,$district,$month,$ethnicity);
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
			$obj['html']="<table id='' class='table table-bordered'><thead>";
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
							$results= $em->getRepository('AppBundle\Entity\Query')->getMonthDistrictAge($data_question,$ans,$district,$month,$age);
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
			$obj['html']="<table id='' class='table table-bordered'><thead>";
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
							$results= $em->getRepository('AppBundle\Entity\Query')->getMonthGenderEthnicity($data_question,$ans,$ethnicity,$gender,$month);
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
			$obj['html']="<table id='' class='table table-bordered'><thead>";
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
							$results= $em->getRepository('AppBundle\Entity\Query')->getMonthGenderAge($data_question,$ans,$age,$gender,$month);
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
			$obj['html']="<table id='' class='table table-bordered'><thead>";
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
							$results= $em->getRepository('AppBundle\Entity\Query')->getMonthEthnicityAge($data_question,$ans,$ethnicity,$month,$age);
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
			$obj['html']="<table id='' class='table table-bordered'><thead>";
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


		//Age,Gender,District,Ethnicity Filter selected(24.DGA)
		if(!isset($data_ethnicity) && isset($data_gender) && isset($data_age) && isset($data_district) && !isset($data_month)){
			$i=0;
			if(count($data_gender)>1){
				$district_span=count($data_age)*count($data_gender);
			}
			else{
				$district_span=count($data_age);
			}
			$gender_span=count($data_age);
			$obj['stack']='normal'; //For stack chart
			$obj['html']="<table id='' class='table table-bordered'><thead>";
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

		//District,Ethnicity,Age Filter selected(25.DEA)
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
			$obj['html']="<table id='' class='table table-bordered'><thead>";
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
			if(count($data_ethnicity)>1){				
				for($i=0;$i<count($data_district);$i++){
					for($j=0;$j<count($data_ethnicity);$j++){
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
					foreach ($data_ethnicity as $ethnicity) {
						foreach ($data_age as $age) {			       									       
							$results= $em->getRepository('AppBundle\Entity\Query')->getDistrictEthnicityAge($data_question,$ans,$district,$ethnicity,$age);
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