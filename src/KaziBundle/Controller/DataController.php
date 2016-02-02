<?php

namespace KaziBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Survey;
use AppBundle\Form\SurveyType;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Shared_Date;
use DateTime;
/**
 * Survey controller.
 *
 * @Route("/data")
 */
class DataController extends Controller
{

    /**
     * Lists all data from excel.
     *
     * @Route("/", name="data")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $file_name = 'uploads/round6/survey.xlsx';
        $sheet_name = 'uploaded_form_ir295a';
        $fileInfo = $this->getCsvData($file_name);

        return array(
            //'round' => 'round6.html.twig',
            'fileInfo' => $fileInfo
            );
    }

    /**
     * Finds and displays all data from excel
     *
     * @Route("/{slug}", name="data_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($slug)//$id //removed annotation @Method("GET")
    {
        $file_name = 'uploads/round'.$slug.'/survey.xlsx';

        if($slug == 1) {
            $sheet_name = 'Round 1 Raw data';
        }
        if($slug == 2) {
            $sheet_name = 'CPS Round 2 - Final (3)';
        }
        if($slug == 3) {
            $sheet_name = 'uploaded_form_g54cmb';
        }
        if($slug == 4) {
            $sheet_name = 'uploaded_form_b57rsp';
        }
        if($slug == 5) {
            $sheet_name = 'uploaded_form_wg5rtx';
        }
        if($slug == 6) {
            $sheet_name = 'uploaded_form_ir295a';
        }

        $fileInfo = $this->getCsvData($file_name, $sheet_name);

        return array(
            'fileInfo' => $fileInfo,
            'slug' => $slug
            );

        /*$round = 'round'.$slug.'.html.twig';

        return array(
            'slug' => $slug,
            'round' => $round
            );*/
    }

    /**
     * Get CSV Data
     * Takes in a file name to read data from
     * If sheet_name is specified, then that particular sheet is read
     * returns a multi-dimentional array with CSV information
     */
    private function getCsvData($file_name, $sheet_name = null){//This function is not used
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
                /* for debugging or adding css */
                /*if ($rowCount > 15) {
                    break;
                }*/
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

            return $fileInfo;
    }
}
