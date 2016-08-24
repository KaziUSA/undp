<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('attr'=>array('class'=>'form-control')))
            ->add('file', 'file', array( 'attr' => array( 'class' => 'form-control' ) ))
            ->add('date', 'date', array('attr'=>array('class'=>'form-control')))
            ->add('documenttype')            
            ->add('language', 'choice', array(
                'choices'  => array('english' => 'English', 'nepali' => 'Nepali'),
                // *this line is important*
                'choices_as_values' => false,
            ))
            ->add('district', 'choice', array(
                'choices'  => array(
                    '' => 'Choose district',
                    'Bhaktapur' => 'Bhaktapur',
                    'Dhading' => 'Dhading',
                    'Dolakha' => 'Dolakha',
                    'Gorkha' => 'Gorkha',
                    'Kathmandu' => 'Kathmandu',
                    'Kavrepalanchowk' => 'Kavrepalanchowk',
                    'Lalitpur' => 'Lalitpur',
                    'Makwanpur' => 'Makwanpur',
                    'Nuwakot' => 'Nuwakot',
                    'Okhaldhunga' => 'Okhaldhunga',
                    'Ramechhap' => 'Ramechhap',
                    'Rasuwa' => 'Rasuwa',
                    'Sindhuli' => 'Sindhuli',
                    'Sindhupalchowk' => 'Sindhupalchowk',
                    ),
                // *this line is important*
                'choices_as_values' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Document'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_document';
    }
}
