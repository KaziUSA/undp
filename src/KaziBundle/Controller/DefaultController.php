<?php

namespace KaziBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Page;
use AppBundle\Form\PageType;

class DefaultController extends Controller
{

    /**
     * Lists all Page entities.
     *
     * @Route("/")
     * 
     * @Template()
     */
    public function indexAction(Request $request)//annotation removed @Method("GET")
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = array('slug'=> 'home');//home is the index page

        $entity_for_id = $em->getRepository('AppBundle:Page')->findBy($criteria);
        $id = $entity_for_id['0']->getId();

        $entity = $em->getRepository('AppBundle:Page')->find($id);//$id - id with key 'o' error
        //print_r($entities);exit();

        return array(
            'entity' => $entity,
        );
    }

    /**
     * @Route("/contactus")
     * @Template()
     */
    public function contactusAction()
    { 
        return array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        );
    }

    /**
     * Finds and displays a Page entity.
     *
     * @Route("/page/{slug}", name="show")
     * 
     * @Template()
     */
    public function showAction($slug, Request $request)//$id //removed annotation @Method("GET")
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = array('slug'=> $slug);

        $entity_for_id = $em->getRepository('AppBundle:Page')->findBy($criteria);
        //print_r($entity_for_id);exit();
        if(empty($entity_for_id)) {
            echo 'Page not found! Sorry about that!';
            exit();
        }
        $id = $entity_for_id['0']->getId();

        $entity = $em->getRepository('AppBundle:Page')->find($id);//$id - id with key 'o' error
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        return array(
            'entity' => $entity,
        );
    }
}
