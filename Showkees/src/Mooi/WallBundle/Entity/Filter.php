<?php

namespace Mooi\WallBundle\Entity;

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Mooi\WallBundle\Entity\Post
 */
class Filter
{
    
    private $subjects;
    private $years;
    
    public function setSubjects($subjects)
    {
        
        $this->subjects = $subjects;
        
    }
    
    public function getSubjects()
    {
        
        return $this->subject;
        
    }
    
    public function setYears($years)
    {
        
        $this->years = $years;
        
    }
    
    public function getYears()
    {
        
        return $this->years;
        
    }

    
}
