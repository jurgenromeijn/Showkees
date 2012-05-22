<?php

namespace Mooi\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserRegistrationType extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $builder->add('first_name', 'text', array('label' => 'Voornaam'));
        $builder->add('preposition', 'text', array(
            'label'    => 'Tussenvoegsel', 
            'required' => false
        ));
        $builder->add('last_name', 'text', array('label' => 'Achternaam'));
        $builder->add('role', null, array('label' => 'Account soort'));
        $builder->add('email', 'email', array(
            'label'    => 'Emailadres', 
            'required' => true)
        );
        $builder->add('password', 'repeated', array (
            'required'        => true,
            'type'            => 'password',
            'first_name'      => 'Wachtwoord',
            'second_name'     => 'Bevestig wachtwoord',
            'invalid_message' => 'De wachtwoorden komen niet overeen!'
        ));
        
    }

    public function getName()
    {
        
        return 'UserRegistration';
        
    }

    public function getDefaultOptions(array $options)
    {
        
        return array(
            'data_class'      => 'Mooi\UserBundle\Entity\User',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'user_create',
        );
        
    }
    
}

?>
