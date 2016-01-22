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
    * Get basic data of the question and answer count when any filter is not selected(1.N)
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
    * Get month filtered data of the question and answer count when only month filter is selected(2.M)
    * @return array
    */
    public function getMonthFilteredArray($que_id,$ans_name,$month_name){
    	$sql='SELECT count(*) as count 
    		FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    		INNER JOIN answer AS a ON sr.answer_id=a.id 
    		WHERE sr.question_id = :qnid AND MONTHNAME(s.date)=:month AND a.name = :name ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('month', $month_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }


    /**
    * Get district filtered data of the question and answer count when only district filter is selected(3.D)
    * @return array
    */
    public function getDistrictFilteredArray($que_id,$ans_name,$district_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `district` AS d ON s.district_id=d.id 
    	WHERE d.name=:dname AND sr.question_id = :qnid AND a.name = :name';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('dname', $district_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }


    /**
    * Get gender filtered data of the question and answer count when only gender filter is selected(4.G)
    * @return array
    */
    public function getGenderFilteredArray($que_id,$ans_name,$gender_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `gender` AS g ON s.gender_id=g.id 
    	WHERE g.name=:gname AND sr.question_id = :qnid AND a.name = :name  ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('gname', $gender_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }

    /**
    * Get ethnicity filtered data when only ethnicity filter is selected(5.E)
    * @return array
    */
    public function getEthnicityFilteredArray($que_id,$ans_name,$ethnicity_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `ethnicity` AS e ON s.ethnicity_id=e.id 
    	WHERE e.name=:ename AND sr.question_id = :qnid AND a.name = :name  ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('ename', $ethnicity_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }

    /**
    * Get age filtered data of the question and answer count when only age filter is selected(6.A)
    * @return array
    */
    public function getAgeFilteredArray($que_id,$ans_name,$age_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `age` AS ag ON s.age_id=ag.id 
    	WHERE ag.name=:agname AND sr.question_id = :qnid AND a.name = :name  ';
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

    /**
    * Get month and district filtered data when month and district filter is selected(7.MD)
    * @return array
    */
    public function getMonthDistrict($que_id,$ans_name,$district_name,$month_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `district` AS d ON s.district_id=d.id 
    	WHERE d.name=:dname AND sr.question_id = :qnid AND a.name = :name AND MONTHNAME(s.date)=:month';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('dname', $district_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->bindValue('month', $month_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }

    /**
    * Get month and gender filtered data(8.MG)
    * @return array
    */
    public function getMonthGender($que_id,$ans_name,$month_name,$gender_name){
    	$sql='SELECT count(*) as count FROM `survey_response` AS sr 
    	INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `gender` AS g ON s.gender_id=g.id 
    	WHERE g.name=:gname AND sr.question_id = :qnid AND a.name = :name AND MONTHNAME(s.date)=:month';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('gname', $gender_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->bindValue('month', $month_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }


    /**
    * Get month and ethnicity filtered data(9.ME)
    * @return array
    */
    public function getMonthEthnicity($que_id,$ans_name,$ethnicity_name,$month_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `ethnicity` AS e ON s.ethnicity_id=e.id 
    	WHERE e.name=:ename AND sr.question_id = :qnid AND a.name = :name AND MONTHNAME(s.date)=:month';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('ename', $ethnicity_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->bindValue('month', $month_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }

    /**
    * Get month and age filtered data(10.MA)
    * @return array
    */
    public function getMonthAge($que_id,$ans_name,$age_name,$month_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `age` AS ag ON s.age_id=ag.id 
    	WHERE ag.name=:agname AND sr.question_id = :qnid AND a.name = :name AND MONTHNAME(s.date)=:month';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('agname', $age_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->bindValue('month', $month_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }


    /**
    * Get month and gender filtered data(11.DG)
    * @return array
    */
    public function getDistrictGender($que_id,$ans_name,$district_name,$gender_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr 
    	INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `gender` AS g ON s.gender_id=g.id 
    	INNER JOIN `district` AS d ON d.id=s.district_id 
    	WHERE g.name=:gname AND sr.question_id = :qnid AND a.name = :name AND d.name= :dname';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('gname', $gender_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->bindValue('dname', $district_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }

    /**
    * Get ethnicity,district filtered data(12.DE)
    * @return array
    */    
    public function getDistrictEthnicity($que_id,$ans_name,$district_name,$ethnicity_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `ethnicity` AS e ON s.ethnicity_id=e.id 
    	INNER JOIN `district` AS d ON d.id=s.district_id 
    	WHERE e.name=:ename AND sr.question_id = :qnid AND a.name = :name AND d.name=:dname ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('dname', $district_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);		
		$statement->bindValue('ename', $ethnicity_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }  

    /**
    * Get age,district filtered data(13.DA)
    * @return array
    */    
    public function getDistrictAge($que_id,$ans_name,$district_name,$age_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `age` AS ag ON s.age_id=ag.id 
    	INNER JOIN `district` AS d ON d.id=s.district_id 
    	WHERE ag.name=:agname AND sr.question_id = :qnid AND a.name = :name AND d.name=:dname ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('dname', $district_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);		
		$statement->bindValue('agname', $age_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }  

    /**
    * Get ethnicity and gender filtered data when ethnicity and gender filter is selected(14.GE)
    * @return array
    */
    public function getEthnicityGender($que_id,$ans_name,$ethnicity_name,$gender_name){
    	$sql='SELECT count(*) as count
    	 FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	 INNER JOIN answer AS a ON sr.answer_id=a.id 
    	 INNER JOIN `ethnicity` AS e ON s.ethnicity_id=e.id 
    	 INNER JOIN `gender` AS g ON g.id=s.gender_id 
    	 WHERE e.name=:ename AND sr.question_id = :qnid AND a.name = :name AND g.name=:gname ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('ename', $ethnicity_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->bindValue('gname', $gender_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }

    /**
    * Get age and gender filtered data when age and gender filter is selected(15.GA)
    * @return array
    */
    public function getAgeGender($que_id,$ans_name,$age_name,$gender_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `age` AS ag ON s.age_id=ag.id 
    	INNER JOIN `gender` AS g ON g.id=s.gender_id 
    	WHERE ag.name=:agname AND sr.question_id = :qnid AND a.name = :name AND g.name=:gname ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('agname', $age_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->bindValue('gname', $gender_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }

    /**
    * Get age,district filtered data(16.EA)
    * @return array
    */    
    public function getEthnicityAge($que_id,$ans_name,$ethnicity_name,$age_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `age` AS ag ON s.age_id=ag.id 
    	INNER JOIN `ethnicity` AS e ON e.id=s.ethnicity_id 
    	WHERE ag.name=:agname AND sr.question_id = :qnid AND a.name = :name AND e.name=:ename ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('ename', $ethnicity_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);		
		$statement->bindValue('agname', $age_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    } 

    
    /**
    * Get gender,month,district filtered data(17.MDG->DGM)
    * @return array
    */    
    public function getMonthDistrictGender($que_id,$ans_name,$district_name,$month_name,$gender_name){
        $sql='SELECT count(*) as count 
        FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
        INNER JOIN answer AS a ON sr.answer_id=a.id 
        INNER JOIN `gender` AS g ON s.gender_id=g.id 
        INNER JOIN `district` AS d ON d.id=s.district_id 
        WHERE g.name=:gname AND sr.question_id = :qnid AND a.name = :name AND MONTHNAME(s.date)=:month AND d.name=:dname ';
        $em = $this->getEntityManager();
        $connection = $em->getConnection(); 
        $statement = $connection->prepare($sql);
        $statement->bindValue('dname', $district_name);
        $statement->bindValue('qnid', $que_id);
        $statement->bindValue('name', $ans_name);
        $statement->bindValue('month', $month_name);
        $statement->bindValue('gname', $gender_name);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;
    }  

    /**
    * Get ethnicity,month,district filtered data(18.MDE->DEM)
    * @return array
    */    
    public function getMonthDistrictEthnicity($que_id,$ans_name,$district_name,$month_name,$ethnicity_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `ethnicity` AS e ON s.ethnicity_id=e.id 
    	INNER JOIN `district` AS d ON d.id=s.district_id 
    	WHERE e.name=:ename AND sr.question_id = :qnid AND a.name = :name AND MONTHNAME(s.date)=:month AND d.name=:dname ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('dname', $district_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->bindValue('month', $month_name);
		$statement->bindValue('ename', $ethnicity_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }  

    /**
    * Get month,district,age filtered data(19.MDA)
    * @return array
    */    
    public function getMonthDistrictAge($que_id,$ans_name,$district_name,$month_name,$age_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `age` AS ag ON s.age_id=ag.id 
    	INNER JOIN `district` AS d ON d.id=s.district_id 
    	WHERE ag.name=:agname AND sr.question_id = :qnid AND a.name = :name AND MONTHNAME(s.date)=:month AND d.name=:dname ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('dname', $district_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->bindValue('month', $month_name);
		$statement->bindValue('agname', $age_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }

    /**
    * Get month,gender,ethnicity filtered data(20.MGE)
    * @return array
    */    
    public function getMonthGenderEthnicity($que_id,$ans_name,$ethnicity_name,$gender_name,$month_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `gender` AS g ON s.gender_id=g.id 
    	INNER JOIN `ethnicity` AS e ON e.id=s.ethnicity_id 
    	WHERE g.name=:gname AND sr.question_id = :qnid AND a.name = :name AND MONTHNAME(s.date)=:month AND e.name=:ename ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('ename', $ethnicity_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->bindValue('month', $month_name);
		$statement->bindValue('gname', $gender_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }

    /**
    * Get month,gender,age filtered data(21.MGA)
    * @return array
    */    
    public function getMonthGenderAge($que_id,$ans_name,$age_name,$gender_name,$month_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `gender` AS g ON s.gender_id=g.id 
    	INNER JOIN `age` AS ag ON ag.id=s.age_id 
    	WHERE g.name=:gname AND sr.question_id = :qnid AND a.name = :name AND MONTHNAME(s.date)=:month AND ag.name=:agname ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('agname', $age_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->bindValue('month', $month_name);
		$statement->bindValue('gname', $gender_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }
    /**
    * Get month,ethnicity,age filtered data(22.MEA)
    * @return array
    */    
    public function getMonthEthnicityAge($que_id,$ans_name,$ethnicity_name,$month_name,$age_name){
        $sql='SELECT count(*) as count 
        FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
        INNER JOIN answer AS a ON sr.answer_id=a.id 
        INNER JOIN `age` AS ag ON s.age_id=ag.id 
        INNER JOIN `ethnicity` AS e ON e.id=s.ethnicity_id 
        WHERE ag.name=:agname AND sr.question_id = :qnid AND a.name = :name AND MONTHNAME(s.date)=:month AND e.name=:ename ';
        $em = $this->getEntityManager();
        $connection = $em->getConnection(); 
        $statement = $connection->prepare($sql);
        $statement->bindValue('ename', $ethnicity_name);
        $statement->bindValue('qnid', $que_id);
        $statement->bindValue('name', $ans_name);
        $statement->bindValue('month', $month_name);
        $statement->bindValue('agname', $age_name);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;
    }

	/**
    * Get ethnicity,gender,district filtered data(23.DGE)
    * @return array
    */    
    public function getEthnicityDistrictGender($que_id,$ans_name,$district_name,$gender_name,$ethnicity_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `ethnicity` AS e ON s.ethnicity_id=e.id 
    	INNER JOIN `gender` AS g ON g.id=s.gender_id 
    	INNER JOIN `district` AS d ON d.id=s.district_id 
    	WHERE e.name=:ename AND sr.question_id = :qnid AND a.name = :name AND g.name=:gname AND d.name=:dname ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('dname', $district_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->bindValue('gname', $gender_name);
		$statement->bindValue('ename', $ethnicity_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }  

    
    /**
    * Get age,gender,district filtered data (24.DGA)
    * @return array
    */
    public function getAgeDistrictGender($que_id,$ans_name,$district_name,$gender_name,$age_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `age` AS ag ON s.age_id=ag.id 
    	INNER JOIN `gender` AS g ON g.id=s.gender_id 
    	INNER JOIN `district` AS d ON d.id=s.district_id 
    	WHERE ag.name=:agname AND sr.question_id = :qnid AND a.name = :name AND g.name=:gname AND d.name=:dname ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('dname', $district_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->bindValue('gname', $gender_name);
		$statement->bindValue('agname', $age_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }

    /**
    * Get age,gender,district filtered data (25.DEA)
    * @return array
    */
    public function getDistrictEthnicityAge($que_id,$ans_name,$district_name,$ethnicity_name,$age_name){
    	$sql='SELECT count(*) as count 
    	FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
    	INNER JOIN answer AS a ON sr.answer_id=a.id 
    	INNER JOIN `age` AS ag ON s.age_id=ag.id 
    	INNER JOIN `ethnicity` AS e ON e.id=s.ethnicity_id 
    	INNER JOIN `district` AS d ON d.id=s.district_id 
    	WHERE ag.name=:agname AND sr.question_id = :qnid AND a.name = :name AND e.name=:ename AND d.name=:dname ';
		$em = $this->getEntityManager();
		$connection = $em->getConnection();	
		$statement = $connection->prepare($sql);
		$statement->bindValue('dname', $district_name);
		$statement->bindValue('qnid', $que_id);
		$statement->bindValue('name', $ans_name);
		$statement->bindValue('ename', $ethnicity_name);
		$statement->bindValue('agname', $age_name);
		$statement->execute();
		$results = $statement->fetchAll();
    	return $results;
    }

   /**
    * Get age,gender,ethnicity filtered data (26.GEA->EAG)
    * @return array
    */
    public function getAgeEthnicityGender($que_id,$ans_name,$ethnicity_name,$gender_name,$age_name){
        $sql='SELECT count(*) as count 
        FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
        INNER JOIN answer AS a ON sr.answer_id=a.id 
        INNER JOIN `age` AS ag ON s.age_id=ag.id 
        INNER JOIN `gender` AS g ON g.id=s.gender_id 
        INNER JOIN `ethnicity` AS e ON e.id=s.ethnicity_id 
        WHERE ag.name=:agname AND sr.question_id = :qnid AND a.name = :name AND g.name=:gname AND e.name=:ename ';
        $em = $this->getEntityManager();
        $connection = $em->getConnection(); 
        $statement = $connection->prepare($sql);
        $statement->bindValue('ename', $ethnicity_name);
        $statement->bindValue('qnid', $que_id);
        $statement->bindValue('name', $ans_name);
        $statement->bindValue('gname', $gender_name);
        $statement->bindValue('agname', $age_name);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;
    }
    
    /**
    * Get district,month,gender,ethnicity filtered data(27.MDGE->DEGM)
    * @return array
    */    
    public function getMDGE($que_id,$ans_name,$ethnicity_name,$gender_name,$month_name,$district_name){
        $sql='SELECT count(*) as count 
        FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
        INNER JOIN answer AS a ON sr.answer_id=a.id 
        INNER JOIN `gender` AS g ON s.gender_id=g.id 
        INNER JOIN `ethnicity` AS e ON e.id=s.ethnicity_id 
        INNER JOIN `district` AS d ON d.id=s.district_id
        WHERE g.name=:gname AND sr.question_id = :qnid AND a.name = :name AND MONTHNAME(s.date)=:month AND e.name=:ename AND d.name=:dname';
        $em = $this->getEntityManager();
        $connection = $em->getConnection(); 
        $statement = $connection->prepare($sql);
        $statement->bindValue('ename', $ethnicity_name);
        $statement->bindValue('dname', $district_name);
        $statement->bindValue('qnid', $que_id);
        $statement->bindValue('name', $ans_name);
        $statement->bindValue('month', $month_name);
        $statement->bindValue('gname', $gender_name);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;
    }
    /**
    * Get district,month,gender,age filtered data(28.MDGA->DAGM)
    * @return array
    */    
    public function getMDGA($que_id,$ans_name,$age_name,$gender_name,$month_name,$district_name){
        $sql='SELECT count(*) as count 
        FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
        INNER JOIN answer AS a ON sr.answer_id=a.id 
        INNER JOIN `gender` AS g ON s.gender_id=g.id 
        INNER JOIN `age` AS ag ON ag.id=s.age_id 
        INNER JOIN `district` AS d ON d.id=s.district_id
        WHERE g.name=:gname AND sr.question_id = :qnid AND a.name = :name AND MONTHNAME(s.date)=:month AND ag.name=:agname AND d.name=:dname';
        $em = $this->getEntityManager();
        $connection = $em->getConnection(); 
        $statement = $connection->prepare($sql);
        $statement->bindValue('agname', $age_name);
        $statement->bindValue('dname', $district_name);
        $statement->bindValue('qnid', $que_id);
        $statement->bindValue('name', $ans_name);
        $statement->bindValue('month', $month_name);
        $statement->bindValue('gname', $gender_name);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;
    }


/**
    * Get age,month,gender,ethnicity filtered data(29.MGEA->EAGM)
    * @return array
    */    
    public function getMGEA($que_id,$ans_name,$age_name,$gender_name,$month_name,$ethnicity_name){
        $sql='SELECT count(*) as count 
        FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
        INNER JOIN answer AS a ON sr.answer_id=a.id 
        INNER JOIN `gender` AS g ON s.gender_id=g.id 
        INNER JOIN `age` AS ag ON ag.id=s.age_id 
        INNER JOIN `ethnicity` AS e ON e.id=s.ethnicity_id
        WHERE g.name=:gname AND sr.question_id = :qnid AND a.name = :name AND MONTHNAME(s.date)=:month AND ag.name=:agname AND e.name=:ename';
        $em = $this->getEntityManager();
        $connection = $em->getConnection(); 
        $statement = $connection->prepare($sql);
        $statement->bindValue('agname', $age_name);
        $statement->bindValue('ename', $ethnicity_name);
        $statement->bindValue('qnid', $que_id);
        $statement->bindValue('name', $ans_name);
        $statement->bindValue('month', $month_name);
        $statement->bindValue('gname', $gender_name);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;
    }
    /**
    * Get district,month,age,ethnicity filtered data(30.MDEA->DEAM)
    * @return array
    */    
    public function getMDEA($que_id,$ans_name,$ethnicity_name,$age_name,$month_name,$district_name){
        $sql='SELECT count(*) as count 
        FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
        INNER JOIN answer AS a ON sr.answer_id=a.id 
        INNER JOIN `age` AS ag ON s.age_id=ag.id 
        INNER JOIN `ethnicity` AS e ON e.id=s.ethnicity_id 
        INNER JOIN `district` AS d ON d.id=s.district_id
        WHERE ag.name=:agname AND sr.question_id = :qnid AND a.name = :name AND MONTHNAME(s.date)=:month AND e.name=:ename AND d.name=:dname';
        $em = $this->getEntityManager();
        $connection = $em->getConnection(); 
        $statement = $connection->prepare($sql);
        $statement->bindValue('ename', $ethnicity_name);
        $statement->bindValue('dname', $district_name);
        $statement->bindValue('qnid', $que_id);
        $statement->bindValue('name', $ans_name);
        $statement->bindValue('month', $month_name);
        $statement->bindValue('agname', $age_name);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;
    }


/**
    * Get district,month,age,ethnicity filtered data(31.DGEA->DEAG)
    * @return array
    */    
    public function getDGEA($que_id,$ans_name,$ethnicity_name,$age_name,$gender_name,$district_name){
        $sql='SELECT count(*) as count 
        FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
        INNER JOIN answer AS a ON sr.answer_id=a.id 
        INNER JOIN `age` AS ag ON s.age_id=ag.id 
        INNER JOIN `ethnicity` AS e ON e.id=s.ethnicity_id 
        INNER JOIN `district` AS d ON d.id=s.district_id
        INNER JOIN `gender` AS g ON g.id=s.gender_id
        WHERE ag.name=:agname AND sr.question_id = :qnid AND a.name = :name AND g.name=:gname AND e.name=:ename AND d.name=:dname';
        $em = $this->getEntityManager();
        $connection = $em->getConnection(); 
        $statement = $connection->prepare($sql);
        $statement->bindValue('ename', $ethnicity_name);
        $statement->bindValue('dname', $district_name);
        $statement->bindValue('qnid', $que_id);
        $statement->bindValue('name', $ans_name);
        $statement->bindValue('gname', $gender_name);
        $statement->bindValue('agname', $age_name);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;
    }

/**
    * Get age,month,gender,ethnicity filtered data(32.MDGEA->DEAGM)
    * @return array
    */    
    public function getMDGEA($que_id,$ans_name,$age_name,$gender_name,$month_name,$ethnicity_name,$district_name){
        $sql='SELECT count(*) as count 
        FROM `survey_response` AS sr INNER JOIN `survey` AS s ON sr.survey_id=s.id 
        INNER JOIN answer AS a ON sr.answer_id=a.id 
        INNER JOIN `gender` AS g ON s.gender_id=g.id 
        INNER JOIN `age` AS ag ON ag.id=s.age_id 
        INNER JOIN `ethnicity` AS e ON e.id=s.ethnicity_id
        INNER JOIN `district` AS d ON d.id=s.district_id
        WHERE g.name=:gname AND sr.question_id = :qnid AND a.name = :name AND MONTHNAME(s.date)=:month AND ag.name=:agname AND e.name=:ename AND d.name=:dname';
        $em = $this->getEntityManager();
        $connection = $em->getConnection(); 
        $statement = $connection->prepare($sql);
        $statement->bindValue('agname', $age_name);
        $statement->bindValue('ename', $ethnicity_name);
        $statement->bindValue('qnid', $que_id);
        $statement->bindValue('name', $ans_name);
        $statement->bindValue('month', $month_name);
        $statement->bindValue('gname', $gender_name);
        $statement->bindValue('dname', $district_name);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;
    }
}