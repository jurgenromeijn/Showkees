<?php

namespace Mooi\WallBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SubjectType extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $builder->add('name', 'text', array('label' => 'Naam*'));
        $builder->add('description', 'textarea', array(
            'label' => 'Beschrijving',
            'required' => false
        ));
        
    }

    public function getName()
    {
        
        return 'Subject';
        
    }
    
    public function getDefaultOptions(array $options)
    {
        
        return array(
            'data_class'      => 'Mooi\Wallbundle\Entity\Subject',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'subject',
        );
        
    }

    
}

?>
