<?php

namespace Mooi\WallBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class WallFilterType extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $builder->add('subject', null, array(
            'label' => 'Vakken',
            'empty_value' => 'Kies een vak'
        ));
        $builder->add('time', null, array(
            'label' => 'Jaartal',
            'empty_value' => 'Kies een jaartal'
        ));
        
    }

    public function getName()
    {
        
        return 'WallFilter';
        
    }
    
    public function getDefaultOptions(array $options)
    {
        
        return array(
            'data_class'        => 'Mooi\WallBundle\Entity\Post',
            'csrf_protection'   => FALSE

        );
        
    }
    
}

?>
