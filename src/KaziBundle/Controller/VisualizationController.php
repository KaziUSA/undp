<?php

namespace KaziBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Visualization controller.
 *
 * @Route("/visualization")
 */
class VisualizationController extends Controller
{
	/**
	*
	*@Route("/", name="visualization")	
	*@Method("GET")
    *@Template()
	*/
	public function indexAction(){
		return array(); 	

	}

}