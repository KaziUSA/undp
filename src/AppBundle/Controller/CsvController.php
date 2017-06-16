<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Shared_Date;
use DateTime;
use AppBundle\Entity\Interviewer;
use AppBundle\Entity\Survey;
use AppBundle\Entity\Age;
use AppBundle\Entity\Gender;
use AppBundle\Entity\Vdc;
use AppBundle\Entity\Ethnicity;
use AppBundle\Entity\Question;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Cardholder;
use AppBundle\Entity\Cardtype;
use AppBundle\Entity\SurveyResponse;

use Symfony\Component\HttpFoundation\Response;//for response
use Phax\CoreBundle\Model\PhaxAction;//for phax commandline
use Phax\CoreBundle\Model\PhaxReaction;//for phax commandline

class CsvController extends Controller
{
    private $count = 0;
    private $rowCount = 0;
    /**
     * @Route("/csv")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/update")
     * @Template()
     */
    public function updateAction()
    {
        $phaxReaction = new PhaxReaction();
        $sheet_name = '';
        $file_name = '/Users/shrestha/Sites/undp/web/uploads/phase2/round2/FsR2Update.xlsx';
        $file_name = '/var/www/html/web/uploads/phase2/round2/FsR2Update.xlsx';

        // This will disable the javascript callback
        $phaxReaction->setMetaMessage('New Surveys is being updated from : '. $file_name);
        $objReader = PHPExcel_IOFactory::createReaderForFile($file_name);
        
        //If specific Sheet is specified then sheet is selected
        if($sheet_name != null){
            $objReader->setLoadSheetsOnly(array($sheet_name));
        }
        
        $objReader->setReadDataOnly(true);
        
        $objPHPExcel = $objReader->load($file_name);
        
        //Getting the number of rows and columns
        $highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        
        
        //$fileInfo = array();
        $rowCount = 0;
        
        
        foreach ($objPHPExcel->setActiveSheetIndex(0)->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            
            $row = array();
            $columnCount = 0;
            foreach ($cellIterator as $cell) {
                if (!is_null($cell)) {
                    
                    //This is converting the second column to Date Format
                    //TODO:: Make sure date format anywhere is captured properly and not just the second column
                    if (($columnCount == 2) && ($rowCount > 0)){
                        $value = $cell->getValue();
                        //$value = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value)); 
                        
                    }else{
                        $value = $cell->getCalculatedValue();    
                        if(PHPExcel_Shared_Date::isDateTime($cell)) {
                            $value = $cell->getValue();    
                            $value = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value)); 
                        }
                    }
                    
                    array_push($row, $value);
                    $columnCount++;
        
                    }
                }
                if ($rowCount > 0)
                {
                    $this->showCsv($row);    
                }
                unset($row);
                //array_push($fileInfo, $row);
                $rowCount++;
            }

        return $phaxReaction;
    }
    function showCsv($row){
         $surveyId = $row[0];
         $em = $this->getDoctrine()->getManager();
         $repository = $em->getRepository('AppBundle\Entity\SurveyResponse');
         $surveyResponse = $repository->findOneBy(array('survey' => $row[0], 'question' => 42));
        echo $surveyResponse->getId() . "\n";
    if (!$surveyResponse) {
        throw $this->createNotFoundException(
            'No survey found for id '.$surveyId
        );
    }

    $surveyResponse->setAnswer($this->getAnswerByShData($row[8]));
    $em->flush();

    //return $this->redirectToRoute('homepage');
        
        
        //echo  $row[0] . ' -- '. $this->getAnswerByShData($row[8])->getId() . "\n";
    }

    /**
     * @Route("/upload")
     * @Template()
     */
    public function uploadAction($file)//PhaxAction $phaxAction
    {
        // USE THIS TO RUN THIS ACTION
        // sf phax:action CsvController upload  -p file:round7/test1
        
        
        echo "******************************************************\n";
        echo "*             WELCOME TO CSV UPLOADER                *\n";
        echo "*          ==============================            *\n";
        echo "*                 By Kazi Studios                    *\n"; 
        echo "******************************************************\n";
        
        echo "\n";
        echo "\n";
        //$fileInfo = $this->getCsvData('/Users/shrestha/Sites/undp/web/uploads/survey.xlsx', 'uploaded_form_g54cmb');
        
        
        //$this->getCsvData('/var/www/html/web/uploads/phase3/R-FEB/Reconstruction_Feb'.$file.".xlsx");
        $this->getCsvData('/Users/shrestha/Sites/undp/web/uploads/phase3/R-FEB/Reconstruction_Feb'.$file.".xlsx");
        
        
        echo "\n";
        echo "CSV upload completed \n";
        
        
        
        $phaxReaction = new PhaxReaction();

        // This will disable the javascript callback
        $phaxReaction->setMetaMessage('New Surveys have been added from : '. $file.".xlsx");

        return $phaxReaction;

        
    }
    
    private function setCsvData($row)
    {
            //Adding interviewer data
            $interviewer = $this->addInterviewer('NDRI', 'NDRI');
            
            
            $survey = new Survey();
            $survey->setTerm(11); //MAKE SURE TO CHANGE THIS EVERY TERM
            $survey->setInterviewer($interviewer);
            $survey->setDate(DateTime::createFromFormat('Y-m-d', '2017-02-15'));
            
            $survey->setAge($this->getAgeByData($row[9]));
            $survey->setGender($this->getGenderByData($row[10]));
            $survey->setEthnicity($this->getEthnicityByData($row[12]));
            $survey->setOccupation($this->getOccupationByData($row[14]));
        
            $survey->setDisability(0); //NOT DISABLED
            //if ($row[7] == "No difficulty"){
              //  $survey->setDisability(0);
            //}else{
              //  $survey->setDisability(1);
            //}
        
            //$survey->setCardholder($this->getCardholderByData($row[5]));
            //$survey->setCardtype($this->getCardtypeByData ($row[11]));
            
            $survey->setDistrict($this->getDistrictByData($row[7]));
            $survey->setVdc($this->getVdcByData($row[2], $row[8]));

            $survey->setWard(0);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($survey);
            $em->flush();
            
            $this->count++;
            echo "Adding Survey Count :". $this->count ."\r";
            
        ////////////////FOOD SECURITY AND LIVELIHOOD QUESTIONS///////////////////
        /*
            // Question 1
            $this->createSurveyResponse($survey, 57, $row[12]);
            // Question 2
            $this->createSurveyResponseLv($survey, 58, $row[13]);
            // Question 3
            $this->createSurveyResponseFmT($survey, 59, $row[14]);
            // Question 4
            $this->createSurveyResponseGfd($survey, 60, $row[15]);
            // Question 5
            $this->createSurveyResponse($survey, 61, $row[16]);
            // Question 6
            $this->createSurveyResponse($survey, 62, $row[17]);
            // Question 7
            $this->createSurveyResponseSkd($survey, 63, $row[18]);
            // Question 8
            $this->createSurveyResponse($survey, 64, $row[19]);
            // Question 9
            $this->createSurveyResponseYn($survey, 65, $row[20]);
            // Question 10
            $this->createSurveyResponse($survey, 66, $row[21]);
          */
        
        ////////////////PROTECTION QUESTIONS///////////////////
        /*
            // Question 1
            $this->createSurveyResponseYn($survey, 78, $row[11]);
            // Question 2
            $this->createSurveyResponseYn($survey, 79, $row[12]);
            // Question 3
            $this->createSurveyResponseYn($survey, 80, $row[13]);
            // Question 4
            $this->createSurveyResponseYn($survey, 81, $row[14]);
            // Question 5
            $this->createSurveyResponseYn($survey, 82, $row[15]);
            // Question 6
            $this->createSurveyResponseYn($survey, 83, $row[16]);
            // Question 7
            $this->createSurveyResponseYn($survey, 84, $row[17]);
        */ 
        ////////////////RECONSTRUCTION QUESTIONS///////////////////
        
            // Question 1
            $this->createSurveyResponseYn($survey, 67, $row[18]);
            // Question 2
            $this->createSurveyResponseYn($survey, 68, $row[19]);
            // Question 3
            $this->createSurveyResponseCn($survey, 69, $row[20]);
            // Question 4
            //$this->createSurveyResponseYn($survey, 70, $row[21]);
            // Question 5
            $this->createSurveyResponseRcvH($survey, 71, $row[22]);
            // Question 6
            $this->createSurveyResponseYn($survey, 72, $row[23]);
            // Question 7
            $this->createSurveyResponseYn($survey, 73, $row[24]);
            // Question 8
            $this->createSurveyResponseYn($survey, 74, $row[25]);
            // Question 9
            $this->createSurveyResponseYn($survey, 75, $row[26]);
            // Question 10
            $this->createSurveyResponseCrn($survey, 76, $row[27]);
            // Question 11
            $this->createSurveyResponseYn($survey, 77, $row[28]);
        
            unset($survey);
            unset($row);
            unset($interviewer);  
            
        
            return true;
        
    }
    
    private function createSurveyResponse($survey, $questionId, $answer)
    {
            $em = $this->getDoctrine()->getManager();
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);

            //$question = $this->getDoctrine()->getRepository('AppBundle:Question')->find($questionId);
        
            $surveyResponse->setQuestion($em->getReference('AppBundle\Entity\Question', $questionId));
            
            $surveyResponse->setAnswer($this->getAnswerByData($answer));

            $em->persist($surveyResponse);
            $em->flush();   
    }
    private function createSurveyResponseTxt($survey, $questionId, $answer)
    {
            $em = $this->getDoctrine()->getManager();
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);

            //$question = $this->getDoctrine()->getRepository('AppBundle:Question')->find($questionId);
        
            $surveyResponse->setQuestion($em->getReference('AppBundle\Entity\Question', $questionId));
            
            $surveyResponse->setAnswer($this->getAnswerByDataTxt($answer));

            $em->persist($surveyResponse);
            $em->flush();   
    }
    private function createSurveyResponseYn($survey, $questionId, $answer)
    {
            $em = $this->getDoctrine()->getManager();
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);
        
            $surveyResponse->setQuestion($em->getReference('AppBundle\Entity\Question', $questionId));
            
            $surveyResponse->setAnswer($this->getAnswerByYnData($answer));

            $em->persist($surveyResponse);
            $em->flush();   
    }
    private function createSurveyResponseLv($survey, $questionId, $answer)
    {
            $em = $this->getDoctrine()->getManager();
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);
        
            $surveyResponse->setQuestion($em->getReference('AppBundle\Entity\Question', $questionId));
            
            $surveyResponse->setAnswer($this->getAnswerByLvData($answer));

            $em->persist($surveyResponse);
            $em->flush();   
    }
    private function createSurveyResponseFmT($survey, $questionId, $answer)
    {
            $em = $this->getDoctrine()->getManager();
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);
        
            $surveyResponse->setQuestion($em->getReference('AppBundle\Entity\Question', $questionId));
            
            $surveyResponse->setAnswer($this->getAnswerByFmData($answer));

            $em->persist($surveyResponse);
            $em->flush();   
    }
    private function createSurveyResponseGfd($survey, $questionId, $answer)
    {
            $em = $this->getDoctrine()->getManager();
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);
        
            $surveyResponse->setQuestion($em->getReference('AppBundle\Entity\Question', $questionId));
            
            $surveyResponse->setAnswer($this->getAnswerByGfData($answer));

            $em->persist($surveyResponse);
            $em->flush();   
    }
    private function createSurveyResponseSkd($survey, $questionId, $answer)
    {
            $em = $this->getDoctrine()->getManager();
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);
        
            $surveyResponse->setQuestion($em->getReference('AppBundle\Entity\Question', $questionId));
            
            $surveyResponse->setAnswer($this->getAnswerBySkData($answer));

            $em->persist($surveyResponse);
            $em->flush();   
    }
    private function createSurveyResponseSh($survey, $questionId, $answer)
    {
            $em = $this->getDoctrine()->getManager();
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);
        
            $surveyResponse->setQuestion($em->getReference('AppBundle\Entity\Question', $questionId));
            
            $surveyResponse->setAnswer($this->getAnswerByShData($answer));

            $em->persist($surveyResponse);
            $em->flush();   
    }
    private function createSurveyResponseCn($survey, $questionId, $answer)
    {
            $em = $this->getDoctrine()->getManager();
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);
        
            $surveyResponse->setQuestion($em->getReference('AppBundle\Entity\Question', $questionId));
            
            $surveyResponse->setAnswer($this->getAnswerByCnData($answer));

            $em->persist($surveyResponse);
            $em->flush();   
    }
    private function createSurveyResponseRcvH($survey, $questionId, $answer)
    {
            $em = $this->getDoctrine()->getManager();
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);
        
            $surveyResponse->setQuestion($em->getReference('AppBundle\Entity\Question', $questionId));
            
            $surveyResponse->setAnswer($this->getAnswerByRcvHData($answer));

            $em->persist($surveyResponse);
            $em->flush();   
    }
    private function createSurveyResponseCrn($survey, $questionId, $answer)
    {
            $em = $this->getDoctrine()->getManager();
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);
        
            $surveyResponse->setQuestion($em->getReference('AppBundle\Entity\Question', $questionId));
            
            $surveyResponse->setAnswer($this->getAnswerByCrnData($answer));

            $em->persist($surveyResponse);
            $em->flush();   
    }
    /* Food Security Question  */
    private function createSurveyResponseFs($survey, $questionId, $answer)
    {
            $em = $this->getDoctrine()->getManager();
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);

            //$question = $this->getDoctrine()->getRepository('AppBundle:Question')->find($questionId);
        
            $surveyResponse->setQuestion($em->getReference('AppBundle\Entity\Question', $questionId));
            
                $response = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')
               ->findOneBy(array(
                   'name' => $response
                ));
            
        
            
            $surveyResponse->setAnswer($response);

            $em->persist($surveyResponse);
            $em->flush();   
    }
    /**
     * Get CSV Data
     * Takes in a file name to read data from
     * If sheet_name is specified, then that particular sheet is read
     * returns a multi-dimentional array with CSV information
     */
    private function getCsvData($file_name, $sheet_name = null){
        $objReader = PHPExcel_IOFactory::createReaderForFile($file_name);
        
        //If specific Sheet is specified then sheet is selected
        if($sheet_name != null){
            $objReader->setLoadSheetsOnly(array($sheet_name));
        }
        
        $objReader->setReadDataOnly(true);
        
        $objPHPExcel = $objReader->load($file_name);
        
        //Getting the number of rows and columns
        $highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        
        
        //$fileInfo = array();
        $rowCount = 0;
        
        
        foreach ($objPHPExcel->setActiveSheetIndex(0)->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            
            $row = array();
            $columnCount = 0;
            foreach ($cellIterator as $cell) {
                if (!is_null($cell)) {
                    
                    //This is converting the second column to Date Format
                    //TODO:: Make sure date format anywhere is captured properly and not just the second column
                    if (($columnCount == 2) && ($rowCount > 0)){
                        $value = $cell->getValue();
                        //$value = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value)); 
                        
                    }else{
                        $value = $cell->getCalculatedValue();    
                        if(PHPExcel_Shared_Date::isDateTime($cell)) {
                            $value = $cell->getValue();    
                            $value = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value)); 
                        }
                    }
                    
                    array_push($row, $value);
                    $columnCount++;
        
                    }
                }
                if ($rowCount > 0)
                {
                    $this->setCsvData($row);    
                }
                unset($row);
                //array_push($fileInfo, $row);
                $rowCount++;
            }
        
            return true;
        }
     /**
     * Fix CSV Data
     * Takes in a file name to read data from
     * If sheet_name is specified, then that particular sheet is read
     * returns a multi-dimentional array with CSV information
     */
    private function readCsvData($file_name, $sheet_name = null){
        $objReader = PHPExcel_IOFactory::createReaderForFile($file_name);
        
        //If specific Sheet is specified then sheet is selected
        if($sheet_name != null){
            $objReader->setLoadSheetsOnly(array($sheet_name));
        }
        
        $objReader->setReadDataOnly(true);
        
        $objPHPExcel = $objReader->load($file_name);
        
        //Getting the number of rows and columns
        $highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        
        
        //$fileInfo = array();
        $rowCount = 0;
        
        
        foreach ($objPHPExcel->setActiveSheetIndex(0)->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            
            $row = array();
            $columnCount = 0;
            foreach ($cellIterator as $cell) {
                if (!is_null($cell)) {
                    
                    
                    $value = $cell->getCalculatedValue();    
                    if(PHPExcel_Shared_Date::isDateTime($cell)) {
                        $value = $cell->getValue();    
                        $value = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value)); 
                    }

                    array_push($row, $value);
                    $columnCount++;
        
                    }
                }
                if ($rowCount > 0)
                {
                    $this->fixCsvData($row);    
                }
                unset($row);
                //array_push($fileInfo, $row);
                $rowCount++;
            }
        
            return true;
        }
    /**
     * Adds the interviewer information if it doesn't already exist
     */
    private function addInterviewer($name, $agency)
    {
        
        $interviewer = $this->getDoctrine()
               ->getRepository('AppBundle:Interviewer')
               ->findOneBy(array(
                   'name' => $name,
                   'agency' => $agency
                ));
        
        if($interviewer)
            return $interviewer;
        
        $interviewer = new Interviewer();
        $interviewer->setName($name);
        $interviewer->setAgency($agency);
        
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($interviewer);
        $em->flush();
        
        return $interviewer;
    }
    private function getAgeByData($data){
        $data = str_replace("_", "-", $data);
        $response = $data;
        if ($data == "55-greater"){
            $response = "55+";
        }
        if ($data == "55"){
            $response = "55+";
        }
        if ($data == "refused"){
            $response = "Refused";
        }
        if ($data == "don - t - know"){
            $response = "Dont't Know";   
        }
        if ($data == "don-t-know"){
            $response = "Dont't Know";   
        }
        
        
        
        
        $age = $this->getDoctrine()
               ->getRepository('AppBundle:Age')
               ->findOneBy(array(
                   'name' => $response
                ));
        

        return $age;
    }
    
    private function getGenderByData($data){
        $response = $data;
        if ($data == "male"){
            $response = "Male";
        }
        if ($data == "female"){
            $response = "Female";
        }
        if ($data == "other"){
            $response = "Other";   
        }
        
        $gender = $this->getDoctrine()
               ->getRepository('AppBundle:Gender')
               ->findOneBy(array(
                   'name' => $response
                ));
        return $gender;
    }
    private function getEthnicityByData($data){
        $response = $data;
        if ($data == "other"){
            $response = "Other";   
        }
        
        $ethnicity = $this->getDoctrine()
               ->getRepository('AppBundle:Ethnicity')
               ->findOneBy(array(
                   'name' => $response
                ));
        return $ethnicity;
    }
    private function getCardholderByData($data){
        $response = $data;
        if ($data == "other"){
            $response = "Other";   
        }
        
        $cardholder = $this->getDoctrine()
               ->getRepository('AppBundle:Cardholder')
               ->findOneBy(array(
                   'name' => $response
                ));
        return $cardholder;
    }
    private function getCardtypeByData($data){
        $response = $data;
        $id = 3;
        if ($data == "other"){
            $id = 3;   
        }
        
        if (substr($data, 0,1) == "A"){
            $id = 1;   
        }
        if (substr($data, 0,1) == "B"){
            $id = 2;   
        }
        if (substr($data, 0,1) == "N"){
            $id = 3;   
        }
        if (substr($data, 0,1) == "D"){
            $id = 4;   
        }
        if (substr($data, 0,1) == "H"){
            $id = 4;   
        }
        if (substr($data, 0,1) == "R"){
            $id = 5;   
        }
        
        $cardtype = $this->getDoctrine()
               ->getRepository('AppBundle:Cardtype')
               ->find($id);
        return $cardtype;
    }
    private function getOccupationByData($data){
     
        $repository = $this->getDoctrine()->getRepository('AppBundle:Gender');
        
        if ($data == "farmer_laborer"){
            $id = 1;
        }
        if ($data == "Farmer/laborer"){
            $id = 1;
        }
        if ($data == "Farmer/Laborer"){
            $id = 1;
        }
        if ($data == "Farmer/Labourer"){
            $id = 1;
        }
        if ($data == "Farmer/Laborer"){
            $id = 1;
        }
        if ($data == "Agriculture"){
            $id = 1;
        }
        if ($data == "Labourer"){
            $id = 1;
        }
        if ($data == "skilled_worker"){
            $id = 2;
        }
        if ($data == "Skilled worker (i.e. carpenter)"){
            $id = 2;
        }
        if ($data == "skilled_worker__i_e__carpenter"){
            $id = 2;
        }
        if ($data == "Skilled worker (i.e. carpenter, masons)"){
            $id = 2;
        }
        
        if (strpos("x".$data,'Skilled') !== false) {
            $id = 2;
        }
        if ($data == "ngo_worker_business"){
            $id = 3;
        }
        if ($data == "NGO worker/Business"){
            $id = 3;
        }
        if ($data == "ngo_worker_bus"){
            $id = 3;
        }
        if ($data == "NGO worker"){
            $id = 3;
        }
        if ($data == "I/NGO worker"){
            $id = 3;
        }
        if ($data == "government_ser"){
            $id = 4;   
        }
        if ($data == "Government (i.e. teacher, health worker, army)"){
            $id = 4;   
        }
        if ($data == "Government job"){
            $id = 4;
        }
        if (strpos("x".$data,'Government') !== false) {
            $id = 4;
        }
        
        
        if ($data == "government_service__i_e__teach"){
            $id = 4;   
        }    
        if ($data == "Government (i.e. teacher, health worker, army)                                 "){
            $id = 4;   
        }
        
        if ($data == "other"){
            $id = 5;   
        }
        if ($data == "Other"){
            $id = 5;   
        }
        if ($data == "Others"){
            $id = 5;   
        }
        if ($data == "Business"){
            $id = 6;   
        }
        if ($data == "Business"){
            $id = 6;
        }
        if ($data == "Home maker/ Housewife"){
            $id = 7;   
        }
        if ($data[0] == "H"){
            $id = 7;   
        }
        if ($data == "I don't do anything"){
            $id = 8;   
        }
        if ($data == "Unemployed"){
            $id = 8;   
        }
        
        if(substr($data, 0,5) == 'I don'){
            $id=8;
        }
        
        if ($data == "Student"){
            $id = 9;   
        }
        if ($data == "Shopkeeper"){
            $id = 10;   
        }
        if ($data == "Private sector job"){
            $id = 11;   
        }
        if ($data == "Public Sector Job"){
            $id = 12;   
        }
        
        
        
        $occupation = $this->getDoctrine()
               ->getRepository('AppBundle:Occupation')->find($id);
        return $occupation;
    }
    private function getDistrictByData($data){
        $district = $this->getDoctrine()
               ->getRepository('AppBundle:District')
               ->findOneBy(array(
                   'name' => $data
                ));
        
        return $district;
    }
    private function getVdcByData($data, $district){
        if ($data == "Hetauda Submetropolitan City"){
            $data = "Hetauda Municipality";
        }
        $vdc = $this->getDoctrine()
               ->getRepository('AppBundle:Vdc')
               ->findOneBy(array(
                   'name' => $data
                ));
        
        if($vdc)
            return $vdc;
        
        $vdc = new Vdc();
        $vdc->setName($data);
        $vdc->setDistrict($district);
        $vdc->setRegion(' ');
        $vdc->setDistrictCode('0');
        $vdc->setCode('0');
        $vdc->setLat('0');
        $vdc->setLng('0');
        $vdc->setShape(' ');
        
        
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($vdc);
        $em->flush();
        
        return $vdc;
    }
    private function getAnswerByData($data){
        $response = $data[0];
        $id=0;
        switch ($response) {
            case "D":
                $id = 6;
                break;
            case "N":
                $id = 1;
                break;
            case "S":
                $id = 4;
                break;
            case "C":
                $id = 5;
                break;
            case "A":
                $id = 5;
                break;
                default:
                $id = 0;    
        }
        if($id == 1){
         if ($data[4] == 'v'){ $id = 2; }
         if ($data[4] == 'm'){ $id = 2; }
        }
        
        $answer = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')->find($id);
        return $answer;
    }
    private function getAnswerByDataTxt($data){
        $response = $data[0];
        $id=0;
        
        switch ($response) {
            case "N":
                $id=1;
                if($data[4] == "v"){ $id = 2; }
                if($data[4] == "r"){ $id = 3; }
                break;
            case "S":
                $id = 4;
                break;
            case "C":
                $id = 5;
                break;
            case "D":
                $id = 6;
                break;
            case "d":
                $id = 6;
                break;
            case "R":
                $id = 7;
                break;
            default:
                $id = 0;
        }
        $answer = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')->find($id);
        return $answer;
    }
    public function getAnswerByYnData($answer){
        $response = $answer[0];
        $id=0;
        
        
        switch ($response) {
            case "Y":
                $id = 161;
                //$id=117;
                break;
            case "N":
                $id = 162;
                //$id=118;
                break;
            case "D":
                $id = 163;
                //$id=119;
                break;
            case "R":
                $id = 164;
                //$id=120;
                break;
            case "1":
                $id = 161;
                break;
            case "2":
                $id = 162;
                break;
            case "3":
                $id = 163;
                break;
            
                default:
                $id = 0;
        }
        
        $answer = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')->find($id);
        return $answer;
    }
    public function getAnswerByCrnData($answer){
        $response = $answer[0];
        $id=0;
        
        
        switch ($response) {
            case "Y":
                $id = 212;
                break;
            case "N":
                $id = 215;
                break;
            case "D":
                $id = 216;
                break;
            
                default:
                $id = 0;
        }
        if($id == 215){
            if($answer[9] == 'b'){ $id = 213; }
            if($answer[9] == 'd'){ $id = 214; }
        }
        $answer = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')->find($id);
        return $answer;
    }
    public function getAnswerByRcvHData($answer){
        $response = $answer[0];
        $id=0;
        
        
        switch ($response) {
            case "Y":
                $id = 212;
                break;
            case "N":
                $id = 215;
                break;
            case "D":
                $id = 216;
                break;
            
                default:
                $id = 0;
        }
        if($id == 215){
            if($answer[9] == 'b'){ $id = 213; }
            if($answer[9] == 'd'){ $id = 214; }
        }
        $answer = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')->find($id);
        return $answer;
    }
    public function getAnswerByCnData($answer){
        $response = $answer[0];
        $id=0;
        
        
        switch ($response) {
            case "D":
                $id = 207;
                break;
            case "H":
                $id = 208;
                break;
            case "N":
                $id = 210;
                break;
            case "P":
                $id = 211;
                break;
            
                default:
                $id = 0;
        }
        if($id == 208){
            if($answer[5] == 'n'){ $id = 209; }
        }
        $answer = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')->find($id);
        return $answer;
    }
    public function getAnswerBySkData($answer){
        $response = substr($answer, 0, 2);
        $id=0;
        
        switch ($response) {
            case "Be":
                $id = 193;
                break;
            case "Ca":
                $id = 194;
                break;
            case "Co":
                $id = 195;
                break;
            case "Dr":
                $id = 196;
                break;
            case "El":
                $id = 197;
                break;
            case "En":
                $id = 198;
                break;
            case "Ha":
                $id = 199;
                break;
            case "Ma":
                $id = 200;
                break;
            case "Mo":
                $id = 201;
                break;
            case "Ne":
                $id = 202;
                break;
            case "Ot":
                $id = 203;
                break;
            case "Ro":
                $id = 204;
                break;
            case "Ta":
                $id = 205;
                break;
            case "Ot":
                $id = 206;
                break;
                default:
                $id=0;
        }
        
        $answer = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')->find($id);
        return $answer;
    }
    public function getAnswerByGfData($answer){
        $response = substr($answer, 0, 3);
        $id=0;
        
        switch ($response) {
            case "All":
                $id = 187;
                break;
            case "Hal":
                $id = 188;
                break;
            case "Lit":
                $id = 189;
                break;
            case "Mor":
                $id = 190;
                break;
            case "Mos":
                $id = 191;
                break;
            case "Non":
                $id = 192;
                break;
                default:
                $id=0;
        }
        if($id==180){
            if(substr($answer, 0, 4) == 'Teac'){
                $id=181;
            }
        }
        if($id==174){
            if(substr($answer, 8, 1) == 'u'){
                $id=175;
            }
        }
        $answer = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')->find($id);
        return $answer;
    }
    public function getAnswerByFmData($answer){
        
        $id=0;
        
        
        switch ($answer) {
            case "Own":
                $id = 184;
                break;
            case "Rent":
                $id = 185;
                break;
            case "No":
                $id = 186;
                break;
                default:
                $id=0;
        }
        if($id==180){
            if(substr($answer, 0, 4) == 'Teac'){
                $id=181;
            }
        }
        if($id==174){
            if(substr($answer, 8, 1) == 'u'){
                $id=175;
            }
        }
        $answer = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')->find($id);
        return $answer;
    }
    public function getAnswerByLvData($answer){
        $response = substr($answer, 0, 2);
        $id=0;
        
        
        switch ($response) {
            case "Ag":
                $id = 165;
                break;
            case "Bu":
                $id = 166;
                break;
            case "Ca":
                $id = 167;
                break;
            case "Co":
                $id = 168;
                break;
            case "Do":
                $id = 169;
                break;
            case "Dr":
                $id = 170;
                break;
            case "Go":
                $id = 171;
                break;
            case "Gu":
                $id = 172;
                break;
            case "I/":
                $id = 173;
                break;
            case "Jo":
                $id = 174;
                break;
            case "La":
                $id = 176;
                break;
            case "Ma":
                $id = 177;
                break;
            case "No":
                $id = 182;
                break;
            case "Ot":
                $id = 183;
                break;
            case "Re":
                $id = 178;
                break;
            case "Ta":
                $id = 179;
                break;
            case "Te":
                $id = 180;
                break;
                default:
                $id=0;
        }
        if($id==180){
            if(substr($answer, 0, 4) == 'Teac'){
                $id=181;
            }
        }
        if($id==174){
            if(substr($answer, 8, 1) == 'u'){
                $id=175;
            }
        }
        $answer = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')->find($id);
        return $answer;
    }
    public function getAnswerByShData($answer){
        $response = $answer;
        $id=0;
        
        
        switch ($response) {
            case "In permanent shelter where we are currently staying":
                $id = 152;
                break;
            case "In temporary shelter where we are currently staying":
                $id = 153;
                break;
            case "With friends/family where we are currently staying":
                $id = 154;
                break;
            case "At collective site where we are currently staying":
                $id = 155;
                break;
            case "In permanent shelter at temporary location that is safer during monsoon":
                $id = 156;
                break;
            case "In temporary shelter at a temporary location that is safer during monsoon":
                $id = 157;
                break;
            case "With friends/family at a temporary location that is safer during monsoon":
                $id = 158;
                break;
            case "At collective site at a temporary location that is safer during monsoon":
                $id = 159;
                break;
            case "Other ":
                $id = 160;
                break;
                default:
                $id=0;
        }
        //return $id;
        $answer = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')->find($id);
        return $answer;
    }
    
    private function getAnswer1aByData($data){
        
        $id=0;
        switch ($data) {
            case "short_term_she":
                $id = 7;
                break;
            case "Short-term shelter (tent/shelterbox)":
                $id = 7;
                break;
            case "short_term_shelter__tent_shelter":
                $id = 7;
                break;
            case "long_term_shelter__housing":
                $id = 8;
                break;
            case "Long-term shelter (housing)":
                $id = 8;
                break;        
            case "clean_water":
                $id = 9;
                break;
            case "Clean water":
                $id = 9;
                break;
            case "financial_support":
                $id = 10;
                break;
            case "Financial support":
                $id = 10;
                break;
            case "education":
                $id = 11;
                break;
            case "healthcare":
                $id = 12;
                break;
            case "Healthcare":
                $id = 12;
                break;
            case "psychosocial_counseling":
                $id = 13;
                break;
            case "Psychosocial counseling":
                $id = 13;
                break;
            case "seeds_and_fertilizers":
                $id = 14;
                break;
            case "Seeds and fertilizers":
                $id = 14;
                break;
            case "food":
                $id = 15;
                break;
            case "Food":
                $id = 15;
                break;
            case "toilets_sanitation":
                $id = 16;
                break;
            case "Toilets/sanitation":
                $id=16;
                break;
            case "livelihoods":
                $id = 17;
                break;
            case "Livelihoods":
                $id = 17;
                break;
            
            case "housing_inspections":
                $id = 18;
                break;
            case "Housing inspections":
                $id = 18;
                break;
            case "other":
                $id = 19;
                break;
            case "Other":
                $id = 19;
                break;
            default:
                $id = 0;
        }
        
        $answer = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')->find($id);
        return $answer;
    }
    private function getAnswer2aByData($data){
        
        $id=0;
        switch ($data) {
            case "building_mater":
                $id = 7;
                break;
            case "cash_for_work":
                $id = 7;
                break;
            case "housing_inspec":
                $id = 8;
                break;
            case "seeds_and_fert":
                $id = 9;
                break;
            case "financial_support":
                $id = 10;
                break;
            case "education":
                $id = 11;
                break;
            case "healthcare":
                $id = 12;
                break;
            case "psychosocial_counseling":
                $id = 13;
                break;
            case "seeds_and_fertilizers":
                $id = 14;
                break;
            case "food":
                $id = 15;
                break;
            case "toilets_sanitation":
                $id = 16;
                break;
            case "livelihoods":
                $id = 17;
                break;
            case "housing_inspections":
                $id = 18;
                break;
            case "other":
                $id = 19;
                break;
            default:
                $id = 0;
        }
        
        $answer = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')->find($id);
        return $answer;
    }
    /**
     * @Route("/fix")
     * @Template()
     */
    public function fixAction($file)//PhaxAction $phaxAction
    {
        // USE THIS TO RUN THIS ACTION
        // sf phax:action CsvController fix  
        $this->rowCount = 0;
        
        echo "******************************************************\n";
        echo "*             WELCOME TO CSV FIXER                   *\n";
        echo "*          ==============================            *\n";
        echo "*                 By Kazi Studios                    *\n"; 
        echo "******************************************************\n";
        
        echo "\n";
        echo "\n";
        
        
        
        //$this->getCsvData('/var/www/html/web/uploads/'.$file.".xlsx");
        $this->readCsvData('/Users/shrestha/Sites/undp/web/uploads/'.$file.".xlsx");
        
        
        echo "\n";
        echo "CSV fix completed \n";
        
        
        
        $phaxReaction = new PhaxReaction();

        // This will disable the javascript callback
        $phaxReaction->setMetaMessage('Surveys have been fixed from : '. $file.".xlsx");

        return $phaxReaction;
    }
    private function fixCsvData($row)
    {
        if (substr($row[11], 0,1) == "Y"){
            echo 6947+$this->rowCount .", ";   
        }
        
        
        
        $this->rowCount++;
        return true;
            
    }
    private function getYesNoAnswer($data)
    {
        $id=0;
        switch ($data) {
            case "not_at_all":
                $id = 1;
                break;
            case "not_very_much":
                $id = 2;
                break;
            case "neutral":
                $id = 3;
                break;
            case "somewhat_yes":
                $id = 4;
                break;
            case "completely_yes":
                $id = 5;
                break;
            case "don_t_know":
                $id = 6;
                break;
            default:
                $id = 0;
        }
        
        $answer = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')->find($id);
        return $answer;
    }

}
