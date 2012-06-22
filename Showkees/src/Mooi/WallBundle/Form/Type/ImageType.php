<?php

namespace Mooi\WallBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ImageType extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $builder->add('file', 'file', array(
            'required' => false,
            'label'    => 'Afbeelding'
        ));
        
    }

    public function getName()
    {
        
        return 'Image';
        
    }
    
    public function getDefaultOptions(array $options)
    {
        
        return array(
            'data_class' => 'Mooi\WallBundle\Entity\Image'         
        );
        
    }
    
}

?>
