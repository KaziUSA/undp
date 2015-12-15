<?php

namespace KaziBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
}
