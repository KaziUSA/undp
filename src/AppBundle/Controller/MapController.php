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
                //Q2. Are your main reconstruction needs being addressed
                $q2_district = [36, 31, 30, 29, 28, 27, 26, 25, 24, 23, 22, 21, 20, 12];
                //id = 
                //if($i == 23)
                if(in_array($i, $q2_district))
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
        // $properties['name'] = $properties['id'] . '. ' . $entity->getName();
        $properties['name'] = $entity->getName();
        //TODO: need to fix randum number
        $properties['boys'] = rand(0, 800);
        $properties['girls'] =rand(0, 800);

        /* TODO: Need to ask? Is this been used or just added for demo? */
        /* Need to make dynamic */

        //Question: Besides building your home, What is your biggest reconstruction priority?
        if($properties['name'] == 'Sindhupalchowk') {
            /*$properties['total'] = "Fulpingkatti, Sindhupalchowk: There is scarcity of water, due to which it is difficult to reconstruct our house.<br><br>Fulpingkatti, Sindhupalchowk: More priority needs to be given to educational institutes like schools.";*/
            $properties['total'] = "Fulpingkatti, Sindhupalchowk: It is difficult to reconstruct house due to water shortage.";
            
            $properties['bgColor'] = "brown";
        } 
        else if($properties['name'] == 'Lalitpur') {
            $properties['total'] = "Godawari, Lalitpur: Most of us (Dalit) do not have land ownership documents. Hence, we are excluded from the beneficiary list. We need government cash support.";
            
            $properties['bgColor'] = "yellow";
        } 
        else if($properties['name'] == 'Gorkha') {
            $properties['total'] = "Barpak, Gorkha: I am not included in the beneficiary list though I am a real earthquake victim.";
            
            $properties['bgColor'] = "red";
        }
        else {
            // $properties['total'] = $properties['girls']+$properties['boys'];
            $properties['total'] = $properties['name'] . " people saying";

            $properties['bgColor'] = "black";
        }
        
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
