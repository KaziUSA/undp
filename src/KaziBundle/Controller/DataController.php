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
        /*$file_name = 'uploads/round6/survey.xlsx';
        $sheet_name = 'uploaded_form_ir295a';
        $fileInfo = $this->getCsvData($file_name);*/

        return array(
            'round' => 'round7.html.twig',
            //'fileInfo' => $fileInfo
            );
    }

    /**
     * Finds and displays all data from excel
     *
     * @Route("/{slug}", name="data_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($slug)//$id
    {
        /* evoke this by curl http://localhost/data/1 -o test1.html.twig */

        /* comment this after use: for phase 1 - generating html from xlxs */
        /*$file_name = 'uploads/round'.$slug.'/survey.xlsx';

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
        if($slug == 7) {
            $sheet_name = 'uploaded_form_xdn830';
        }*/

        /* for phase 2: generating html from xlsx */
        /*$file_name = 'temp/for-xlsx-to-html/phase2/round2/cleanned-fsl/test3.xlsx';

        $sheet_name = 'Sheet1';

        $fileInfo = $this->getCsvData($file_name, $sheet_name);

        return array(
            'fileInfo' => $fileInfo,
            'slug' => $slug
            );*/

        
        /* comment this after use: for phase 2 - generating html from xlxs */
        //eg. http://localhost:8000/data/food-security-livelihood
        /*$file_name = ;
        $sheet_name = 'Foglio1';

        $fileInfo = $this->getCsvData($file_name, $sheet_name);
        var_dump($this);exit();

        return array(
            'fileInfo' => $fileInfo,
            'slug' => $slug
            );*/



        /* for phase 1 - showing data in site */
        $round = 'round'.$slug.'.html.twig';

        return array(
            'slug' => $slug,
            'round' => $round
            );
    }

    /**
     * Finds and displays all data from excel
     *
     * @Route("/phase2/{slug}", name="data_show_phase2")
     * @Method("GET")
     * @Template()
     */
    public function showPhase2Action($slug)//$id
    {
        /* for phase 1 - showing data in site */
        if($slug != '') {
            $round = 'data/phase2/'.$slug.'.html.twig';

            if($slug == 'round1-fsl') {
                $page_title = 'Round 1 (Food Security and Livelihood)';
            } 
            else if ($slug == 'round1-protection') {
                $page_title = 'Round 1 (Protection)';
            }
            else if ($slug == 'round1-reconstruction') {
                $page_title = 'Round 1 (Reconstruction)';
            }
            else if ($slug == 'round2-fsl') {
                $page_title = 'Round 2 (Food Security and Livelihood)';
            }
            else if ($slug == 'round2-protection') {
                $page_title = 'Round 2 (Protection)';
            }
        } else {
            // $round = 'data/phase2/round1-fsl.html.twig';
        }

        return array(
            'slug' => $slug,
            'round' => $round,
            'page_title' => $page_title
            );
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
