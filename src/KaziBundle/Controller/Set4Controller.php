<?php

namespace KaziBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
/**
 * Set4 controller.
 *
 * @Route("/set4")
 */
class Set4Controller extends Controller
{
    /**
	*
	*@Route("/", name="set4")	
	*@Method("GET")
    *@Template()	
	*/
    public function indexAction()
    {
        //Question Single Choice as selectbox
			$form = $this->createFormbuilder()
		    ->add('questions', 'entity',array(
			    'class' => 'AppBundle:Question',
			    'query_builder' => function(EntityRepository $er) {
			                         return $er->createQueryBuilder('q')
			                             
                                         ->where('q.id > 77')
                                         ->orderBy('q.id', 'ASC');
			                     },
			    'choices_as_values' => false,		    
			))
		    ->getForm();
		    $choices['questions'] = $form->createView();
		    
		    //AgeGroup Multiple choices as checkbox
		    $form = $this->createFormbuilder()
		    ->add('ages', 'entity',array(
		    'class' => 'AppBundle:Age',
		    'query_builder' => function(EntityRepository $er) {
		                         return $er->createQueryBuilder('a')
		                             ->orderBy('a.name', 'ASC');
		                     },
		    'choices_as_values' => false,	    
			'expanded' => true,
			'multiple' => true
			))
		    ->getForm();
		    $choices['agegroups'] = $form->createView();

			//Multiple choices district as checkbox
		    $form = $this->createFormbuilder()
		    ->add('districts', 'entity',array(
		    'class' => 'AppBundle:District',
		    'query_builder' => function(EntityRepository $er) {
		                         return $er->createQueryBuilder('d')
		                         		->where('d.name = \'Sindhuli\' or d.name = \'Gorkha\' or d.name = \'Bhaktapur\' or d.name = \'Dhading\' or d.name = \'Kathmandu\' or d.name = \'Dolakha\' or d.name = \'Kavrepalanchok\' or d.name = \'Lalitpur\' or d.name = \'Makwanpur\' or d.name = \'Okhaldhunga\' or d.name = \'Nuwakot\' or d.name = \'Ramechhap\' or d.name = \'Rasuwa\' or d.name = \'Sindhupalchowk\' ')
		                             ->orderBy('d.name', 'ASC');
		                     },
		    'choices_as_values' => false,
		    'expanded' => true,
			'multiple' => true	    
			))
		    ->getForm();
		    $choices['districts'] = $form->createView();

		    //Multiple choices Ethnicity as checkbox
		    $form = $this->createFormbuilder()
		    ->add('ethnicities', 'entity',array(
		    'class' => 'AppBundle:Ethnicity',
		    'query_builder' => function(EntityRepository $er) {
		                         return $er->createQueryBuilder('et')
		                             ->orderBy('et.name', 'ASC');
		                     },
		    'choices_as_values' => false,
		    'expanded' => true,
			'multiple' => true	    
			))
		    ->getForm();
		    $choices['ethnicities'] = $form->createView();
		    
		    //Gender Multiple Choice as checkbox
			$form = $this->createFormbuilder()
		    ->add('gender', 'entity',array(
			    'class' => 'AppBundle:Gender',
			    'query_builder' => function(EntityRepository $er) {
			                         return $er->createQueryBuilder('gender')
			                             ->orderBy('gender.name', 'ASC');
			                     },
			    'choices_as_values' => false,
			    'expanded' => true,
				'multiple' => true			    
			))
		    ->getForm();
		    $choices['gender'] = $form->createView();
		    

		    return array(	
					//'questions' => $questions,
					'form' => $choices
					); 	
    }

}
