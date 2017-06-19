<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

// use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class IssueQuestionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'attr' => array(
                    'class' => 'full-width'
                    )
                )
            )
            ->add('issueType')
            // ->add('keyFindingsMonth')
            ->add('keyFindingsMonth', 'choice', array(
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
            ->add('keyFindings', null, array(
                'attr' => array(
                        'class' => 'ckeditor'
                    )
                )
            )
            ->add('issueMapName')
            ->add('image_title')
            // ->add('image_url')
            ->add('file')
            ->add('image_desc')
            ->add('image_credit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\IssueQuestion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_issuequestion';
    }
}
