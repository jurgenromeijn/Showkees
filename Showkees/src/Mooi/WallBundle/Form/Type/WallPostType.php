<?php

namespace Mooi\WallBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class WallPostType extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $builder->add('text', 'textarea');
        $builder->add('subject', null, array('label' => 'Vakken'));
        /*$builder->add('upload', 'entity', array(
            'class' => 'Mooi\WallBundle:Image',
            'name' => 'file'
        ));*/
        
    }

    public function getName()
    {
        
        return 'WallPost';
        
    }
    
    public function getDefaultOptions(array $options)
    {
        
        return array(
            'data_class'    => 'Mooi\WallBundle\Entity\Post',
            'image'         => 'Mooi\WallBundle\Entity\Image'          
        );
        
    }
    
}

?>
