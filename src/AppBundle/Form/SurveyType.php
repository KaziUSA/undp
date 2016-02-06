<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SurveyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('interviewer')
            ->add('date')
            ->add('term')
            
            ->add('age')
            ->add('gender')
            ->add('ethnicity')
            ->add('district')
            ->add('vdc')
            ->add('ward')
            
            
            ->add('disability')
            ->add('occupation')
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Survey'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_survey';
    }
}
