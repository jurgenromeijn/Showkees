<?php

namespace Mooi\WallBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class WallPostType extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $builder->add('text', 'textarea', array('label' => 'Bericht toevoegen'));
        $builder->add('subjects', null, array('label' => 'Vakken'));
        $builder->add('time', 'hidden', array(
            'data' => time(),
        ));
        
    }

    public function getName()
    {
        
        return 'WallPost';
        
    }
    
    public function getDefaultOptions(array $options)
    {
        
        return array(
            'data_class'      => 'Mooi\WallBundle\Entity\Post'
        );
        
    }
    
}

?>
