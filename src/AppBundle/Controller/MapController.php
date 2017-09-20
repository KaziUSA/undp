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
     * @Route("/nepal/{question_id}")
     * @Template()
     */
    public function nepalAction($question_id)
    {
        
        //getting district id from IssueMapDistrict
        $em = $this->getDoctrine()->getManager();

        //TODO: Need to make this part dynamic
        //first get question detail - 
        //TODO: so call this using /nepal/{question_id} from issueController
        $question_id = $question_id;//eg. 1 - use this to get issueMapSayings also
        $question_detail = $em->getRepository('AppBundle:IssueQuestion')->findById($question_id);
        // var_dump($question_detail[0]->getIssueMapName()); exit();
        //var_dump($question_detail[0]->getIssueMapName()->getId());exit();

        if($question_detail[0]->getIssueMapName() != '') {
            $issueMapNameId = $question_detail[0]->getIssueMapName()->getId();
        } 
        else {
            $issueMapNameId = 1;
        }

        $district = $em->getRepository('AppBundle:IssueMapDistricts')->findByIssueMapName($issueMapNameId);

        // var_dump($district); exit();

        //Q2. Are your main reconstruction needs being addressed
        // $q2_district = [36, 31, 30, 29, 28, 27, 26, 25, 24, 23, 22, 21, 20, 12];

        $q2_district = array();

        foreach ($district as $district_item) {
            // var_dump($district_item->getDistrict()->getId());
            array_push($q2_district, $district_item->getDistrict()->getId());
        }
        // var_dump($q2_district);
        // exit();


        $geoJSON = array();
        $geoJSON['type'] = "FeatureCollection";
        $features = array();
        for ($i = 1; $i < 76; $i++){              
                //if($i == 23)
                
                //selected district only
                if(in_array($i, $q2_district))
               array_push($features, $this->districtJson($i, $question_id));

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
    private function districtJson($id, $question_id)
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
        
        $properties['bgColor'] = '#0b9444';

        //Reading csv and setting boys and girls value
        //adding this - for unicef test map showing for demo
        /*$handle = fopen("/Users/nikesh/Sites/undp/web/uploads/csv/literacy-2001.csv", "r");
        while (($data = fgetcsv($handle, 1000, ","))) {
            if($properties['name'] == $data[0]) {                
                $properties['boys'] = (float) $data[1];//male
                $properties['girls'] = (float) $data[2];//female
            }
            //others will not have properties boys, girls
        }*/

        /* TODO: Need to ask? Is this been used or just added for demo? */
        /* Need to make dynamic */

        //Question: Besides building your home, What is your biggest reconstruction priority?

        //pulling people saying here
        // var_dump($question_id); exit();
        $em = $this->getDoctrine()->getManager();

        $sayings = $em->getRepository('AppBundle:IssueMapSayings')->findByIssueQuestion($question_id);
        // var_dump($sayings);
        foreach ($sayings as $say) {
            // var_dump($say->getDistrict()->getName());
            if($properties['name'] == $say->getDistrict()->getName()) {
                $properties['name'] = $say->getLocation() . ', ' . $say->getDistrict()->getName();

                $properties['total'] = $say->getSaying();

                if($say->getHrrp() != '')
                $properties['total'] .= '<br><br><div class="hrrp">HRRP: ' . $say->getHrrp() . '</div>';

                /*if($say->getDistrict()->getColor() != '') {
                    $properties['bgColor'] = $say->getDistrict()->getColor();
                } */
                $properties['bgColor'] = '#349de7';
            }
        }
        // exit();


        
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
