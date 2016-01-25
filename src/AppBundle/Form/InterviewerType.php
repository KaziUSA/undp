<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InterviewerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array( 'attr' => array( 'class' => 'form-control' ) ) )
            ->add('agency', 'text', array( 'attr' => array( 'class' => 'form-control' ) ) )
            ->add('phone', 'text', array( 'attr' => array( 'class' => 'form-control' ) ) )
            ->add('email', 'text', array( 'attr' => array( 'class' => 'form-control' ) ) )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Interviewer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_interviewer';
    }
}
