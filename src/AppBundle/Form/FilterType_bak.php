<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Question

class FilterType extends AbstractType{
	private $cat;

    public function __construct(Question $categories)
    {
        $this->cat = $categories->getNomSousCategorie();
    }
	/**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('titre', 'text')
            ->add('categories', 'choice', array(
            'choices' => $this->cat,
        
		));
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Question',
        ));
    }

    public function getName()
    {
        return 'Question';
    }
}
}