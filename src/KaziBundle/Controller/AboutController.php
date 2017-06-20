<?php

namespace KaziBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Page;
use AppBundle\Form\PageType;

use Symfony\Component\HttpFoundation\Response;

/**
 * About controller.
 *
 * @Route("/about")
 */
class AboutController extends Controller
{

    /**
     * Lists all Page entities.
     *
     * @Route("/", name="about")
     * 
     * @Template()
     */
    public function indexAction(Request $request)//annotation removed @Method("GET")
    {
        $em = $this->getDoctrine()->getManager();
        
        $criteria = array('slug'=> 'about');//about need to change to contact
        $entity = $em->getRepository('AppBundle:Page')->findBy($criteria);//$id - id with key 'o' error


        $criteria_perception = array('slug'=>'perception-survey-methodology');
        $entity_perception = $em->getRepository('AppBundle:Page')->findBy($criteria_perception);
        // var_dump($entity_perception);exit();


        $criteria_contactus = array('slug'=>'contactus');
        $entity_contactus = $em->getRepository('AppBundle:Page')->findBy($criteria_contactus);

        return array(
            'entity' => $entity[0],
            //'response' => $response
            'entity_perception' => $entity_perception[0],
            'entity_contactus' => $entity_contactus[0],
        );       
    }
}