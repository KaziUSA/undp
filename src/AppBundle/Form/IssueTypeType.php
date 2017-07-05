<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IssueTypeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            // ->add('month')            
            ->add('month', 'choice', array(
                'choices'  => array(
                    1  => 'January',
                    2  => 'February',
                    3  => 'March',
                    4  => 'April',
                    5  => 'May',
                    6  => 'June',
                    7  => 'July',
                    8  => 'August',
                    9  => 'September',
                    10  => 'October',
                    11  => 'November',
                    12  => 'December',
                ),
            ))
            // ->add('year')            
            ->add('year', 'choice', array(
                'choices'  => array(
                    2015  => '2015',
                    2016  => '2016',
                    2017  => '2017',
                    2018  => '2018',
                    2019  => '2019',
                    2020  => '2020',
                    2021  => '2021',
                ),
                'data' => 2017
            ))
            ->add('isHomepage', 'choice', array(
                'choices'  => array(
                    0  => 'No',
                    1  => 'Yes',
                ),
            ))
            ->add('chartType', 'choice', array(
                'choices'  => array(
                    1  => 'Circle Donut',
                    2  => 'Semi circle donut',
                ),
            ))
            ->add('surveyNumber')
            ->add('surveyDetail')
            ->add('surveyMen')
            ->add('surveyWomen')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\IssueType'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_issuetype';
    }
}
