<?php

namespace Mooi\WallBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Mooi\WallBundle\Form\Type\ImageType;

class WallPostType extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $builder->add('text', 'textarea', array('label' => 'Bericht'));
        $builder->add('subject', null, array(
            'label' => 'Vak'
        ));
        $builder->add('images', 'collection', array(
            'label' => 'Plaatjes',
            'type' => new ImageType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false
        ));
        
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
