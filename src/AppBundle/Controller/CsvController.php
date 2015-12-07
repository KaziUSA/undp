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
        
        $file_name = 'survey.xlsx';
        $sheet_name = 'uploaded_form_g54cmb';
        
        $objReader = PHPExcel_IOFactory::createReaderForFile($file_name);
        $objReader->setLoadSheetsOnly(array($sheet_name));
        $objReader->setReadDataOnly(true);
        
        $objPHPExcel = $objReader->load($file_name);
        
        $highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
        $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        
        
        $fileInfo = array();
        $rowCount = 0;
        //echo '<table border="1">';
        
        foreach ($objPHPExcel->setActiveSheetIndex(0)->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            //echo '<tr>';
            $row = array();
            foreach ($cellIterator as $cell) {
                if (!is_null($cell)) {
                    $columnCount = 0;
                    $value = $cell->getCalculatedValue();
                    
                    //echo '<td>';
                    //echo $value;
                    //echo '</td>';
                    $fileInfo[$rowCount][$columnCount] = $value;
                    array_push($row, $value);
                    $columnCount++;
        
                }
                //array_push($file
                
            }
            array_push($fileInfo, $row);
                           $rowCount++;
        
          //  echo '</tr>';
        }
        
        //echo '</table>';
		
        //var_dump($fileInfo);
        //exit();
        
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
            );    }

}
