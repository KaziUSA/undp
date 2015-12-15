<?php

namespace KaziBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        
       $sql = "SELECT COUNT(*) as count FROM `survey_response` INNER JOIN `survey` ON survey.id = survey_response.survey_id INNER JOIN ethnicity ON survey.ethnicity_id = ethnicity.id WHERE `answer_id` = :id OR `answer_id` = :id2 GROUP BY survey.ethnicity_id";
        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare($sql);
        $statement->bindValue('id', 1);
        $statement->bindValue('id2', 2);
        $statement->execute();
        $results = $statement->fetchAll();
        
        
        $yes = array();
        
        foreach ($results as $num){
            array_push($yes, $num["count"]);   
        }
        
        $statement = $connection->prepare($sql);
        $statement->bindValue('id', 4);
        $statement->bindValue('id2', 5);
        $statement->execute();
        $negresults = $statement->fetchAll();
        
        $no = array();
        foreach ($negresults as $num){
            array_push($no, $num["count"]);   
        }
        
        $statement = $connection->prepare($sql);
        $statement->bindValue('id', 3);
        $statement->bindValue('id2', 6);
        $statement->execute();
        $otherresults = $statement->fetchAll();
        
        $other = array();
        foreach ($otherresults as $num){
            array_push($other, $num["count"]);   
        }
        
        
        
        return array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'yes'=> $yes,
            'no'  => $no,
            'other' => $other
        );
    }
    /**
     * @Route("/nepal")
     * @Template()
     */
    public function nepalAction()
    {
        
        $geoJSON = array();
        $geoJSON['type'] = "FeatureCollection";
        $features = array();
        for ($i = 1; $i < 76; $i++){
               array_push($features, $this->districtJson($i));
                //$features[$i-1]['properties']['total'] = $features[$i-1]['properties']['id'];
        }
        
        $geoJSON['features'] = $features;
        
        $response = new Response();
        $response->setContent(json_encode($geoJSON));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    /**
     * @Route("/map/{id}", name="district_map")
     * @Method("GET")
     * @Template()
     */
    public function districtAction($id)
    {
       $geoJSON = $this->districtJson($id);
        
        $response = new Response();
        $response->setContent(json_encode($geoJSON));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    /**
     * Prepares district information into JSONArray for all districts
     */
    private function districtJson($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:District')->find($id);
        
        $geoJSON = array();
        $geoJSON['type'] = "Feature";
        $properties = array();
        $properties['id'] = $entity->getId();
        $properties['name'] = $entity->getName();
        $properties['boys'] = 0;
        $properties['girls'] = 0;
        $properties['total'] = 11;
        
        $geoJSON['properties'] = $properties;
        
        $geometry = array();
        $geometry['type'] = 'Polygon';
        $geometry['coordinates'] = $this->fixDistrictData($entity->getShape());
        $geoJSON['geometry'] = $geometry;

        return $geoJSON;
    }
    /**
     * Fixes District Data, parses it and sets it up in an object
     * Takes in a chunk of shape data
     */
    private function fixDistrictData($shape){

        $shape = str_replace('],', ']', $shape);
        $shape = str_replace('[', '', $shape);
        //$entity = str_replace('\n', '', $entity);
        $shape = trim(preg_replace('/\s\s+/', ' ', $shape));
        
        $points = str_getcsv($shape, ']');
        
        $response = array();
        foreach($points as $point){
            $singlePoint = str_getcsv($point);
            array_push($response, $singlePoint);
        }
        array_pop($response);
        return array($response);
    }

}
