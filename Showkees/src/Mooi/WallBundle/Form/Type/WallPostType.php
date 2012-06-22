<?php

namespace Mooi\WallBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class WallPostType extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $builder->add('text', 'textarea', array('label' => 'Bericht'));
        $builder->add('subject', null, array(
            'label' => 'Vakken',
            'empty_value' => 'Kies een vak'
        ));
        /*$builder->add('file', 'file', array(
            'class' => 'Mooi\WallBundle\Entity\Image',
        ));*/
        //$builder->add('attachment', 'file');
        
    }

    public function getName()
    {
        
        return 'WallPost';
        
    }
    
    public function getDefaultOptions(array $options)
    {
        
        return array(
            'data_class'    => 'Mooi\WallBundle\Entity\Post'         
        );
        
    }
    
}

?>
