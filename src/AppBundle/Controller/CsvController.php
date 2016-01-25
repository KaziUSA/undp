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
use AppBundle\Entity\Ethnicity;
use AppBundle\Entity\Question;
use AppBundle\Entity\Answer;
use AppBundle\Entity\SurveyResponse;

use Symfony\Component\HttpFoundation\Response;//for response
use Phax\CoreBundle\Model\PhaxAction;//for phax commandline
use Phax\CoreBundle\Model\PhaxReaction;//for phax commandline

class CsvController extends Controller
{
    private $count = 0;
    /**
     * @Route("/csv")
     * @Template()
     */
    public function indexAction()
    {
    
        /*return array(
            'fileInfo' => $this->getCsvData('uploads/survey1.xlsx')
            //'fileInfo' => $this->getCsvData('uploads/survey2.xlsx')
            //'fileInfo' => $this->getCsvData('uploads/survey3.xlsx')
                
            );    */
        $file_name = 'uploads/round5/survey1.xlsx';
        $sheet_name = '';

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
        
        
        $fileInfo = array();
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
                    if (($columnCount == 0) && ($rowCount > 0)){
                        $value = $cell->getValue();
                        $value = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value)); 
                        
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
                    //$this->setCsvData($row);    
                    array_push($fileInfo, $row);
                    //print_r($row);
                }else{
                    array_push($fileInfo, $row);
                }
                unset($row);
                //array_push($fileInfo, $row);
                $rowCount++;
            }
        

                //print_r($fileInfo); exit();
            return array(
                'fileInfo' => $fileInfo
                );
    }

    /**
     * @Route("/upload")
     * @Template()
     */
    public function uploadAction()//PhaxAction $phaxAction
    {
        // USE THIS TO RUN THIS ACTION
        // sf phax:action CsvController upload  
        
        
        echo "******************************************************\n";
        echo "*             WELCOME TO CSV UPLOADER                *\n";
        echo "*          ==============================            *\n";
        echo "*                 By Kazi Studios                    *\n"; 
        echo "******************************************************\n";
        
        echo "\n";
        echo "\n";
        //$fileInfo = $this->getCsvData('/Users/shrestha/Sites/undp/web/uploads/survey.xlsx', 'uploaded_form_g54cmb');
        
        //$fileInfo = $this->getCsvData('/Users/shrestha/Sites/undp/web/uploads/survey1.xlsx');
        //$fileInfo = $this->getCsvData('/Users/shrestha/Sites/undp/web/uploads/survey2.xlsx');
        //$fileInfo = $this->getCsvData('/Users/shrestha/Sites/undp/web/uploads/survey3.xlsx');
        //$fileInfo = $this->getCsvData('/Users/shrestha/Sites/undp/web/uploads/survey4.xlsx');
        //$this->getCsvData('/Users/shrestha/Sites/undp/web/uploads/survey5.xlsx');
        //$this->getCsvData('/Users/shrestha/Sites/undp/web/uploads/survey6.xlsx');
        $this->getCsvData('/Users/shrestha/Sites/undp/web/uploads/round6/survey6.xlsx');
        
        
        echo "\n";
        echo "CSV upload completed \n";
        
        
        exit();
        
        // Return a phax reation with a success or failure notification
        $phaxReaction = new PhaxReaction();
        echo 'Status: ';

        // This will disable the javascript callback
        $phaxReaction->setMetaMessage('The file has been uploaded.');

        return $phaxReaction;
    }
    private function setCsvData($row)
    {
     //Adding interviewer data
        
            
            $interviewer = $this->addInterviewer($row[1], 'accountability');
            $survey = new Survey();
            $survey->setInterviewer($interviewer);
            $survey->setDate(DateTime::createFromFormat('Y-m-d', $row[0]));
            
            $survey->setAge($this->getAgeByData($row[5]));
            $survey->setGender($this->getGenderByData($row[6]));
            $survey->setEthnicity($this->getEthnicityByData($row[7]));
            $survey->setOccupation($this->getOccupationByData($row[9]));
            if ($row[11] == "no_difficulty"){
                $survey->setDisability(0);
            }else{
                $survey->setDisability(1);
            }
            $survey->setTerm(2);
            $survey->setDistrict($this->getDistrictByData($row[2]));
            $survey->setVdc($this->getVdcByData($row[3]));
            $survey->setWard($row[4]);
            
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($survey);
            $em->flush();
            
            echo "Adding Record Count :". $this->count ."\r";
            $this->count++;
        
            // Question 1
            $this->createSurveyResponse($survey, 1, $row[12]);
            // Question 2
            $this->createSurveyResponse($survey, 5, $row[19]);
            // Question 3
            $this->createSurveyResponse($survey, 8, $row[24]);
            // Question 4
            $this->createSurveyResponse($survey, 11, $row[29]);
            // Question 5
            $this->createSurveyResponse($survey, 14, $row[34]);
            // Question 6
            $this->createSurveyResponse($survey, 17, $row[39]);
            // Question 7
            $this->createSurveyResponse($survey, 19, $row[42]);
            // Question 8
            $this->createSurveyResponse($survey, 22, $row[47]);
            // Question 9
            $this->createSurveyResponse($survey, 23, $row[48]);
            // Question 10
            $this->createSurveyResponse($survey, 28, $row[51]);
            // Question 11
            $this->createSurveyResponse($survey, 29, $row[52]);
            // Question 12
            $this->createSurveyResponse($survey, 30, $row[57]);
            
        
            // Question 1a
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);
            $question = $this->getDoctrine()->getRepository('AppBundle:Question')->find(2);
            $surveyResponse->setQuestion($question);
            
            $surveyResponse->setAnswer($this->getAnswer1aByData($row[14]));
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($surveyResponse);
            $em->flush();
            
            unset($survey);
            unset($row);
            unset($interviewer);   
    }
    
    private function createSurveyResponse($survey, $questionId, $answer)
    {
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);
        
            $question = $this->getDoctrine()->getRepository('AppBundle:Question')->find($questionId);
        
            $surveyResponse->setQuestion($question);
            
            $surveyResponse->setAnswer($this->getAnswer1ByData($answer));
            
            $em = $this->getDoctrine()->getManager();
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
                    if (($columnCount == 0) && ($rowCount > 0)){
                        $value = $cell->getValue();
                        $value = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value)); 
                        
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
        $data = str_replace("_", " - ", $data);
        $response = $data;
        if ($data == "55 - greater"){
            $response = "55+";
        }
        if ($data == "refused"){
            $response = "Refused";
        }
        if ($data == "don - t - know"){
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
    private function getOccupationByData($data){
     
        $repository = $this->getDoctrine()->getRepository('AppBundle:Gender');
        
        if ($data == "farmer_laborer"){
            $id = 1;
        }
        if ($data == "Farmer/laborer"){
            $id = 1;
        }
        if ($data == "skilled_worker"){
            $id = 2;
        }
        if ($data == "Skilled worker (i.e. carpenter)"){
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
        if ($data == "government_ser"){
            $id = 4;   
        }
        if ($data == "Government (i.e. teacher, health worker, army)"){
            $id = 4;   
        }
        if (strpos("x".$data,'Government') !== false) {
            $id = 4;
        }
        if ($data == "Government (i.e. teacher, health worker, army)                                 "){
            $id = 4;   
        }
        
        if ($data == "other"){
            $id = 5;   
        }
        if ($data == "Others"){
            $id = 5;   
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
    private function getVdcByData($data){
        if ($data == "Hetauda Submetropolitan City"){
            $data = "Hetauda Municipality";
        }
        $vdc = $this->getDoctrine()
               ->getRepository('AppBundle:Vdc')
               ->findOneBy(array(
                   'name' => $data
                ));
        return $vdc;
    }
    private function getAnswer1ByData($data){
        $response = $data[0];
        $id=0;
        if ($response == 'd'){
            $id = 6;   
        }else{
         $id = intval($response);   
        }
        
        $answer = $this->getDoctrine()
               ->getRepository('AppBundle:Answer')->find($id);
        return $answer;
    }
    private function getAnswer2ByData($data){
        $response = $data[0];
        $id=0;
        if ($response == 'd'){
            $id = 6;   
        }else{
         $id = intval($response);   
        }
        
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
            case "long_term_shelter__housing":
                $id = 8;
                break;
            case "clean_water":
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

}
