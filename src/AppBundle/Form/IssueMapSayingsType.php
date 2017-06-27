<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IssueMapSayingsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('issueQuestion')
            ->add('district')
            ->add('location')
            ->add('saying', null, array(
                'attr' => array(
                    'class'=>'full-width'
                    )
                )
            )
            ->add('hrrp', null, array(
                'label' => 'HRRP',
                'required'   => false,
                'attr' => array(
                    'class'=>'full-width'
                    )
                )
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\IssueMapSayings'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_issuemapsayings';
    }
}
