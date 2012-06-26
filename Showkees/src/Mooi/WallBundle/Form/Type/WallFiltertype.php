<?php

namespace Mooi\WallBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class WallFilterType extends AbstractType
{
    
    private $subjects;
    private $years;
    
    public function __construct($subjects, $years)
    {
        
        $this->subjects = $subjects;
        $this->years = $years;
        
    }
    
    public function buildForm(FormBuilder $builder, array $options)
    {

        $builder->add('subject', 'choice', array(
            'choices'       => $this->subjects,
            'label'         => 'Vakken',
            'empty_value'   => 'Kies een vak',
            "property_path" => false
        ));
        $builder->add('years', 'choice', array(
            'choices' => $this->years,
            'label' => 'Jaren',
            'empty_value' => 'Kies een jaar',
            "property_path" => false
        ));
        
    }
    
    public function getName()
    {
        
        return 'WallFilter';
        
    }
    
    public function getDefaultOptions(array $options)
    {
        
        return array(
            'csrf_protection'   => FALSE

        );
        
    }
    
}

?>
