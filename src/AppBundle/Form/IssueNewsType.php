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
            ->add('slug')
            ->add('description', null, array(
                'attr' => array(
                        'class' => 'ckeditor'
                    )
                )
            )
            ->add('source')
            // ->add('imageUrl')
            // ->add('image_url')
            ->add('file', null, array(
                'label_format' => 'File (Audio or Image)'
                )
            )//image or audio
            ->add('audioName')
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
