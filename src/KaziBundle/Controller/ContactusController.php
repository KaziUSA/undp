<?php

namespace KaziBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Page;
use AppBundle\Form\PageType;

/**
 * Contactus controller.
 *
 * @Route("/contactus")
 */
class ContactusController extends Controller
{

    /**
     * Lists all Page entities.
     *
     * @Route("/", name="contactus")
     * 
     * @Template()
     */
    public function indexAction(Request $request)//annotation removed @Method("GET")
    {
        //for frontend homepage only
        $data_title = $request->request->get('data_title');
        $data_description = $request->request->get('data_description');

        /*if(isset($title) || isset($data_description)) {
            echo $title . $data_description;
            exit();
        }*/
        $response = array("code" => 100, "success" => true);


        $em = $this->getDoctrine()->getManager();
        $criteria = array('slug'=> 'about');//about need to change to contact

        $entity_for_id = $em->getRepository('AppBundle:Page')->findBy($criteria);
        $id = $entity_for_id['0']->getId();

        $entity = $em->getRepository('AppBundle:Page')->find($id);//$id - id with key 'o' error

        //$entities = $em->getRepository('AppBundle:Page')->findAll();
        //print_r($entities);exit();

        return array(
            'entity' => $entity,
        );
    }
}