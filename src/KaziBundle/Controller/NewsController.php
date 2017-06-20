<?php

namespace KaziBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use KaziBundle\Helper\NewsHelper;

// use AppBundle\Entity\Document;
// use AppBundle\Form\DocumentType;

/**
 * Document controller.
 *
 * @Route("/news")
 */
class NewsController extends Controller
{


    /**
     * Lists all Document entities.
     *
     * @Route("/", name="news")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        /*$criteria = array('status'=> 1);

        $entities = $em->getRepository('AppBundle:Document')->findBy($criteria, array('date'=>'desc'));*/

        $entities = $em->getRepository('AppBundle:IssueNews')->findAll();

        // var_dump($entities);exit();
        $entities_final = array();

        $i = 0;
        foreach ($entities as $entity) {
            $entities_final[$i]['id'] = $entity->getId();
            $entities_final[$i]['name'] = $entity->getName();
            $entities_final[$i]['description'] = $entity->getDescription();
            $entities_final[$i]['imageUrl'] = $entity->getImageUrl();


            //if video url - get the youtube slug
            $youtubeUrlEmbed = '';

            if($entity->getYoutubeUrl() != '') {
                $nhelp = new NewsHelper();
                $youtubeUrlEmbed = $nhelp->getYoutubeUrlEmbed($entity->getYoutubeUrl());
            }

            $entities_final[$i]['youtubeUrlEmbed'] = $youtubeUrlEmbed;

            $i++;  
        }
        // var_dump($entities_final); exit();

        

        

        return array(
            'entities' => $entities_final, //entities
        );
    }


    /**
     * Finds and displays all data from excel
     *
     * @Route("/{id}", name="news_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)//$id 
    {
        $em = $this->getDoctrine()->getManager();
        
        /*$criteria = array('status'=> 1);

        $entities = $em->getRepository('AppBundle:Document')->findBy($criteria, array('date'=>'desc'));*/

        $entity = $em->getRepository('AppBundle:IssueNews')->findById($id);   

        // var_dump($entity);
        //if video url - get the youtube slug
        $youtubeUrlEmbed = '';

        if($entity[0]->getYoutubeUrl() != '') {
            $nhelp = new NewsHelper();
            $youtubeUrlEmbed = $nhelp->getYoutubeUrlEmbed($entity[0]->getYoutubeUrl());
        }

        return array(
            'entity' => $entity[0], //entities
            'youtubeUrlEmbed' => $youtubeUrlEmbed,
        );        
    }

}
