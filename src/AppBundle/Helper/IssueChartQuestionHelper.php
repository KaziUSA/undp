<?php
namespace AppBundle\Helper;

// use Symfony\Component\HttpFoundation\Response;

// Correct use statements here ...

class IssueChartQuestionHelper {

    /*private $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }*/

    public function getIssueChartQuestionDetail($em, $data_id) {
        // $em = $this->getDoctrine()->getManager();

        $entity_issueType = null;            
        $response = null;

        if($data_id != '') {//-1
            // $entity_issueType = $em->getRepository('AppBundle:IssueType')->find($data_id);
            $entity_issueChartQuestion = $em->getRepository('AppBundle:IssueChartQuestion')->find($data_id);

            /*var_dump($entity_issueChartQuestion);
            exit();*/

            $item_info_name = $entity_issueChartQuestion->getIssueQuestion()->getIssueType()->getName();
            $item_info_year = $entity_issueChartQuestion->getIssueQuestion()->getIssueType()->getYear();
            $item_info_month = $entity_issueChartQuestion->getIssueQuestion()->getIssueType()->getMonth();

            $monthNum  = $item_info_month;
            $dateObj   = \DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F'); // March

            //prepare the response
            $item_info = $item_info_name . ' - ' . $monthName . ' ' . $item_info_year;

            $response = array("code" => 100, "success" => true, "result" => $item_info );  

            // return new Response(json_encode($response));
            return $response;
        }
    }
}