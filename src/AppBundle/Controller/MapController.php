<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class MapController extends Controller
{
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
