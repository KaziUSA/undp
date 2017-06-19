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
                $url = urldecode(rawurldecode($entity->getYoutubeUrl()));
                # https://www.youtube.com/watch?v=nn5hCEMyE-E

                preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
                // echo $matches[1];
                // exit();
                $youtubeUrlEmbed = 'https://www.youtube.com/embed/' . $matches[1];
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

    }
}
