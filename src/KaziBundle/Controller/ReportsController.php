<?php

namespace KaziBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Document;
use AppBundle\Form\DocumentType;

/**
 * Document controller.
 *
 * @Route("/reports")
 */
class ReportsController extends Controller
{


    /**
     * Lists all Document entities.
     *
     * @Route("/", name="reports")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = array('status'=> 1);
        $entities = $em->getRepository('AppBundle:Document')
            ->findBy($criteria, array('date'=>'desc'));
        $yearly_months = $this->yearly_months();

        return compact('entities', 'yearly_months');
    }

    private function yearly_months($start = 201501, $end = null) {
        $date_array = [];
        $start_year = substr($start, 0 , 4);
        $start_month = substr($start, 4 , 2);
        $end_year = date('Y');
        $end_month = date('m');

        for ($start_year; $start_year <= $end_year; $start_year++) { 
            $date_array[$start_year] = [];
            
            $j = 12;
            if($start_year == $end_year) {
                $j = $end_month;
            }

            for ($i=1; $i <= $j; $i++) { 
                $i = sprintf("%02d", $i); 
                array_push($date_array[$start_year], $i);
            }
        }

        return $date_array;
    }
}
