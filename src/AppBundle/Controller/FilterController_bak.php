<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Question;
use AppBundle\Form\QuestionType;



class FilterController extends Controller
{
	/**
	*
	*@Route("/filter")	
    *@Template()	
	*/
	public $g = array();
		public function indexAction(){
	// 			$form = $this->createFormbuilder()
	//     ->add('questions', 'choice', 
	//       ['choices' =>$questions,
	//    	    'multiple'  =>  false,
	//     'expanded'  => false,
	//     ]
	// )
			$em = $this->getDoctrine()->getManager();
			$query = $em->createQueryBuilder(
			    'SELECT q.name
			    FROM Question q'
			    );
			// $query_er=function(EntityRepository $er){
			// 	return $er->createQueryBuilder('SELECT q.name
			//     FROM Question q'
			//     );
			// }
			

			$form = $this->createFormbuilder()
	    ->add('questions', 'entity',array(
	    'class' => 'AppBundle:Question',
	    'query_builder' => function(EntityRepository $er) {
	                         return $er->createQueryBuilder('q')
	                             ->orderBy('q.name', 'ASC');
	                     },
	    'choices_as_values' => false,
	    
		))
	    ->getForm();
	  $g['question'] = $form;
	  $form = $this->createFormbuilder()
	    ->add('questions', 'entity',array(
	    'class' => 'AppBundle:Age',
	    'query_builder' => function(EntityRepository $er) {
	                         return $er->createQueryBuilder('a')
	                             ->orderBy('a.name', 'ASC');
	                     },
	    'choices_as_values' => false,	    
		))
	    ->getForm();
	    $g['age'] = $form;
	    return array(	
				//'questions' => $questions,
				'form' => $g['age']->createView()
				);


				


				// $form = $this->createFormBuilder()
			 //  	->add('instructionAction', 'entity', array(
    // 			'required' => true,
			 //    'class' => 'ApplicationTrackpadCommonBundle:InstructionAction',
			 //    'query_builder' => function(EntityRepository $er) use ($user) {
			 //        return $er->createQueryBuilder('c')
		  //           ->where('c.user = :user')
		  //           ->setParameter('user', $user)
		  //           ->orderBy('c.name', 'ASC');
 			// 	}))

	}
	

}