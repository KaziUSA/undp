<?php
// src/AppBundle/Entity/ProductRepository.php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


class QueryRepository extends \Doctrine\ORM\EntityRepository
{
	/**
     * Return all the answer sets of the AJAX retrieved question id
     * @return array
     */
    public function getAnswersArray($que_id)
    {
  		$sql= "SELECT a.name FROM question AS q INNER JOIN answer AS a ON q.answer_group_id=a.answer_group_id WHERE q.id= :id";
		$em = $this->getEntityManager();
		$connection = $em->getConnection();
		$statement = $connection->prepare($sql);
		$statement->bindValue('id', $que_id);
		$statement->execute();
		$results = $statement->fetchAll();
        return $results;
    }

    /**
    * Get basic data of the question and answer count when any filter is not selected
    * @return array
    */
    public function getBasicArray($que_id,$ans_name){
    	$sql= 'SELECT count(*) as count
			FROM `survey_response` AS s INNER JOIN answer AS a ON s.answer_id=a.id 
			WHERE s.question_id = :qnid AND a.name = :name';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();				
		$statement = $connection->prepare($sql);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->execute();
		$results = $statement->fetchAll();
		return $results;
    }
    /**
    * Get age filtered data of the question and answer count when only age filter is selected
    * @return array
    */
    public function getAgeFilteredArray($que_id,$ans_name,$age_name){
    	$sql='SELECT count(*) as count FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id INNER JOIN answer AS a ON sr.answer_id=a.id INNER JOIN `age` AS ag ON s.age_id=ag.id WHERE ag.name=:agname AND sr.question_id = :qnid AND a.name = :name  ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('agname', $age_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }
}