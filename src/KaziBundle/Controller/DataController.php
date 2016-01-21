<?php

namespace KaziBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Survey;
use AppBundle\Form\SurveyType;

/**
 * Survey controller.
 *
 * @Route("/data")
 */
class DataController extends Controller
{

    /**
     * Lists all Survey entities.
     *
     * @Route("/", name="data")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Survey')->findAll();

        return array(
            'entities' => $entities,
        );
    }
}
