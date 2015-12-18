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
    /**
     * @Route("/csv")
     * @Template()
     */
    public function indexAction()
    {
    
        return array(
            'fileInfo' => $this->getCsvData('uploads/survey1.xlsx')
            //'fileInfo' => $this->getCsvData('uploads/survey2.xlsx')
            //'fileInfo' => $this->getCsvData('uploads/survey3.xlsx')
                
            );    
    }

    /**
     * @Route("/upload")
     * @Template()
     */
    public function uploadAction()//PhaxAction $phaxAction
    {
        /*$fileInfo = $this->getCsvData('C:/wamp/www/undp/web/uploads/survey1.xlsx');*/
        
        //$fileInfo = $this->getCsvData('uploads/survey2.xlsx');
        //$fileInfo = $this->getCsvData('uploads/survey3.xlsx');

        //$fileInfo = '';
        
        
        //Grabbing the Labels from the CSV
        /*$titles = array_shift($fileInfo);
        
        foreach ($fileInfo as $row){
            
            //Adding interviewer data
            $interviewer = $this->addInterviewer($row[0], $row[1]);
            
            
            $survey = new Survey();
            $survey->setInterviewer($interviewer);
            $survey->setDate(DateTime::createFromFormat('Y-m-d', $row[2]));
            
            $survey->setAge($this->getAgeByData($row[11]));
            $survey->setGender($this->getGenderByData($row[12]));
            $survey->setEthnicity($this->getEthnicityByData($row[13]));
            $survey->setOccupation($this->getOccupationByData($row[15]));
            if ($row[17] == "no_difficulty"){
                $survey->setDisability(0);
            }else{
                $survey->setDisability(1);
            }
            $survey->setTerm(2);
            $survey->setDistrict($this->getDistrictByData($row[8]));
            $survey->setVdc($this->getVdcByData($row[9]));
            $survey->setWard($row[10]);
            
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($survey);
            $em->flush();
            
            // Question 1
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);
            $question = $this->getDoctrine()->getRepository('AppBundle:Question')->find(1);
            $surveyResponse->setQuestion($question);
            
            $surveyResponse->setAnswer($this->getAnswer1ByData($row[19]));
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($surveyResponse);
            $em->flush();
            
            // Question 1a
            $surveyResponse = new SurveyResponse();
            
            $surveyResponse->setSurvey($survey);
            $question = $this->getDoctrine()->getRepository('AppBundle:Question')->find(2);
            $surveyResponse->setQuestion($question);
            
            $surveyResponse->setAnswer($this->getAnswer1aByData($row[20]));
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($surveyResponse);
            $em->flush();
            
            unset($survey);
            unset($row);
            unset($interviewer);
            
        }
        echo "FINE TILL HERE";
        exit();
        return $this->redirect($this->generateUrl('survey'));
        
        return array(
                'fileInfo' => $this->getCsvData('uploads/survey1.xlsx', 'uploaded_form_g54cmb')
            );*/

        

        // Return a phax reation with a success or failure notification
        $phaxReaction = new PhaxReaction();
        echo 'Status: ';

        // This will disable the javascript callback
        $phaxReaction->setMetaMessage('The file has been uploaded.');

        return $phaxReaction;
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
                    if (($columnCount == 2) && ($rowCount > 0)){
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
                array_push($fileInfo, $row);
                $rowCount++;
            }
        
            return $fileInfo;
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
        if ($data == "skilled_worker"){
            $id = 2;
        }
        if ($data == "ngo_worker_bus"){
            $id = 3;
        }
        if ($data == "government_ser"){
            $id = 4;   
        }
        if ($data == "other"){
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
