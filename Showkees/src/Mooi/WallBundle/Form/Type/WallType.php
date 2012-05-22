<?php

namespace Mooi\WallBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class WallType extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $builder->add('text', 'text', array('label' => 'Bericht toevoegen'));
        //TODO vakken moeten nog toegevoegd worden en uitzoeken hoe een selectbox te maken met info uit DB
        $builder->add('section', 'entity', array(
            'class' => 'Mooi\WallBundle\Entity\Section',
            'query_builder' => function($repository) { return $repository->createQueryBuilder('p')->orderBy('p.id', 'ASC'); },
            'property' => 'name',
        ));

        
    }

    public function getName()
    {
        
        return 'User';
        
    }

    
}

?>
