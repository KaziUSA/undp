<?php

namespace KaziBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Page;
use AppBundle\Form\PageType;

use KaziBundle\Helper\NewsHelper;

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



        //pull 4 news here
        $entities_news = $em->getRepository('AppBundle:IssueNews')->findAll();//only four news

        // var_dump($entities_news);exit();
        $entities_news_final = array();

        $i = 0;
        foreach ($entities_news as $entity_news) {
            $entities_news_final[$i]['id'] = $entity_news->getId();
            $entities_news_final[$i]['name'] = $entity_news->getName();
            $entities_news_final[$i]['description'] = $entity_news->getDescription();
            $entities_news_final[$i]['imageUrl'] = $entity_news->getImageUrl();


            //if video url - get the youtube slug
            $youtubeUrlEmbed = '';

            if($entity_news->getYoutubeUrl() != '') {
                $nhelp = new NewsHelper();
                $youtubeUrlEmbed = $nhelp->getYoutubeUrlEmbed($entity_news->getYoutubeUrl());
            }

            $entities_news_final[$i]['youtubeUrlEmbed'] = $youtubeUrlEmbed;

            $i++;  
        }
        // $entities_news = array();


        //get homepage chart - IssueChartOverview
        $issueType = $em->getRepository('AppBundle:IssueType')->findById(3);
        // var_dump($issueType);
        //TODO: compare chartType of issueType

        $issueChartOverview = $em->getRepository('AppBundle:IssueChartOverview')->findByIssueType(3);
        // var_dump($issueChartOverview); exit();



        return array(
            'entity' => $entity,
            'entities_news' => $entities_news_final,//news
            'issueType' => $issueType[0],
            'issueChartOverview' => $issueChartOverview,
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
        exit();//we don't need this now - we have all about, contact and perception in AboutController
        
        return array();
        /*$em = $this->getDoctrine()->getManager();
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
        );*/
    }
}
