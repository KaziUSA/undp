<?php
namespace UserBundle\Form;

use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array(
                'label' => 'Email',
                'attr' => array( 'class' => 'form-control'), 
                'translation_domain' => 'FOSUserBundle'))
            ->add('username', null, array(
                'label' => 'Username', 
                'attr' => array( 'class' => 'form-control'),
                'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array(
                    'label' => 'Password',
                    'attr' => array( 'class' => 'form-control'),
                    ),
                'second_options' => array(
                    'label' => 'Password Confirmation',
                    'attr' => array( 'class' => 'form-control'),
                    ),
                'invalid_message' => 'Password doesn\'t match.',//fos_user.password.mismatch
            ))
        ;
    }

    public function getParent()
    {
        // Or for Symfony < 2.8
        return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'user_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}