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
     * 
     *
     * @Route("/", name="myajax")
     * @Method("POST")
     * @Template()
     */
	public function indexAction(){
	$request = $this->container->get('request');        
	$data1 = $request->query->get('data_question');
	$data2 = $request->query->get('data2');
	
	//handle data
	
	//prepare the response, e.g.
	$response = array("code" => 100, "success" => true);
	//you can return result as JSON
	return new Response(json_encode($response)); 
	}      
}