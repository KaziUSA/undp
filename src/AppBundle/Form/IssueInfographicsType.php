<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IssueInfographicsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('file')
            /*->add('imageUrl', null, array(
                'label' => 'Icon / Value',
                'required'   => false,
                )
            )*/
            ->add('value')
            ->add('issueInfographicsTitle')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\IssueInfographics'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_issueinfographics';
    }
}
