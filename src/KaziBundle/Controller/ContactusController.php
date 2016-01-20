<?php

namespace KaziBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Page;
use AppBundle\Form\PageType;

/**
 * Contactus controller.
 *
 * @Route("/contactus")
 */
class ContactusController extends Controller
{

    /**
     * Lists all Page entities.
     *
     * @Route("/", name="contactus")
     * 
     * @Template()
     */
    public function indexAction(Request $request)//annotation removed @Method("GET")
    {
        //for frontend homepage only
        $data_name = $request->request->get('data_name');
        $data_address = $request->request->get('data_address');
        $data_email = $request->request->get('data_email');
        $data_phone = $request->request->get('data_phone');
        $data_message = $request->request->get('data_message');

        if(isset($data_name)) {//if there is name
            $to = "nikesh@kazistudios.com";
            $subject = "Contact From UNDP Website";
            
            $txt = '<strong>Name:</strong> ' . $data_name . 
                '<br><strong>Address:</strong> ' . $data_address .
                '<br><strong>Email:</strong> ' . $data_email . 
                '<br><strong>Phone:</strong> ' . $data_phone .
                '<br><strong>Message:</strong> ' . $data_message;

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= "From: <symfony@undp.kazi270.com>" . "\r\n";
            $headers .= "CC: rohit@kazistudios.com" . "\r\n";

            mail($to,$subject,$txt,$headers);
        }
        $response = array("code" => 100, "success" => true);


        $em = $this->getDoctrine()->getManager();
        $criteria = array('slug'=> 'about');//about need to change to contact

        $entity_for_id = $em->getRepository('AppBundle:Page')->findBy($criteria);
        $id = $entity_for_id['0']->getId();

        $entity = $em->getRepository('AppBundle:Page')->find($id);//$id - id with key 'o' error

        //$entities = $em->getRepository('AppBundle:Page')->findAll();
        //print_r($entities);exit();

        return array(
            'entity' => $entity,
        );
    }
}