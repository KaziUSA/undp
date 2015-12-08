<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PHPExcel;
use PHPExcel_IOFactory;

class CsvController extends Controller
{
    /**
     * @Route("/csv")
     * @Template()
     */
    public function indexAction()
    {
        
        $file_name = 'uploads/round2/survey.xlsx';
        $sheet_name = 'uploaded_form_g54cmb';
            $fileInfo = $this->getCsvData($file_name);
        
        return array(
                'fileInfo' => $fileInfo
            );    }

    /**
     * @Route("/upload")
     * @Template()
     */
    public function uploadAction()
    {
        
        return array(
                // ...
            );    
    }
    /**
     * Get CSV Data
     * Takes in a file name to read data from
     * If sheet_name is specified, then that particular sheet is read
     */
    private function getCsvData($file_name, $sheet_name = null){
        $objReader = PHPExcel_IOFactory::createReaderForFile($file_name);
        //If specific Sheet, then use this
        if($sheet_name != null){
            $objReader->setLoadSheetsOnly(array($sheet_name));
        }
        $objReader->setReadDataOnly(true);
        
        $objPHPExcel = $objReader->load($file_name);
        
        $highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        
        
        $fileInfo = array();
        $rowCount = 0;
        
        
        foreach ($objPHPExcel->setActiveSheetIndex(0)->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            
            $row = array();
            foreach ($cellIterator as $cell) {
                if (!is_null($cell)) {
                    $columnCount = 0;
                    $value = $cell->getCalculatedValue();
                    array_push($row, $value);
                    $columnCount++;
        
                    }
                }
                array_push($fileInfo, $row);
                $rowCount++;
            }
            return $fileInfo;
        }

}
