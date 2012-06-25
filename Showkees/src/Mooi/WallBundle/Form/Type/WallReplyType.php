<?php

namespace Mooi\WallBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class WallReplyType extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $builder->add('text', 'textarea', array('label' => 'Reactie'));
        
    }

    public function getName()
    {
        
        return 'WallReply';
        
    }
    
    public function getDefaultOptions(array $options)
    {
        
        return array(
            'data_class'        => 'Mooi\WallBundle\Entity\Post',
            'csrf_protection'   => false,
        );
        
    }
    
}

?>
