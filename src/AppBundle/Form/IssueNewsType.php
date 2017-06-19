<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IssueNewsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', null, array(
                'attr' => array(
                        'class' => 'ckeditor'
                    )
                )
            )
            // ->add('imageUrl')
            // ->add('image_url')
            ->add('file')//image or audio
            // ->add('audioUrl')
            ->add('youtubeUrl')
            //->add('createdDate') //update automatically
            //->add('updatedDate') //update automatically
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\IssueNews'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_issuenews';
    }
}
