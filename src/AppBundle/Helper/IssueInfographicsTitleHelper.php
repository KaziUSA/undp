<?php
namespace AppBundle\Helper;

// use Symfony\Component\HttpFoundation\Response;

// Correct use statements here ...

class IssueInfographicsTitleHelper {

    /*private $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }*/

    public function getIssueInfographicsTitleDetail($em, $data_id) {
        // $em = $this->getDoctrine()->getManager();

        $entity_issueType = null;            
        $response = null;

        if($data_id != '') {//-1
            // $entity_issueType = $em->getRepository('AppBundle:IssueType')->find($data_id);
            $entity_issueInfographicsTitle = $em->getRepository('AppBundle:IssueInfographicsTitle')->find($data_id);

            /*var_dump($entity_issueInfographicsTitle);
            exit();*/

            $item_info_name = $entity_issueInfographicsTitle->getIssueQuestion()->getIssueType()->getName();
            $item_info_year = $entity_issueInfographicsTitle->getIssueQuestion()->getIssueType()->getYear();
            $item_info_month = $entity_issueInfographicsTitle->getIssueQuestion()->getIssueType()->getMonth();

            $monthNum  = $item_info_month;
            $dateObj   = \DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F'); // March


            //also get issueQuestion - since same issueType has multiple District Highlights IssueInfographicsTitle
            $item_info_issueQuestion = $entity_issueInfographicsTitle->getIssueQuestion();

            //prepare the response
            $item_info = $item_info_name . ' - ' . $monthName . ' ' . $item_info_year . ' (' . $item_info_issueQuestion . ')';


            $response = array("code" => 100, "success" => true, "result" => $item_info );  

            // return new Response(json_encode($response));
            return $response;
        }
    }
}