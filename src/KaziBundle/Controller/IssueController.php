<?php

namespace KaziBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

// use AppBundle\Entity\Document;
// use AppBundle\Form\DocumentType;

/**
 * Document controller.
 *
 * @Route("/issue")
 */
class IssueController extends Controller
{


    /**
     * Lists all Document entities.
     *
     * @Route("/", name="issue")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        /*$criteria = array('status'=> 1);

        $entities = $em->getRepository('AppBundle:Document')->findBy($criteria, array('date'=>'desc'));*/

        return array(
            'entities' => 'Issue content from db later',
        );
    }
}
