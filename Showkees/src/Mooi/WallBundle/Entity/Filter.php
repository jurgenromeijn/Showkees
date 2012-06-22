<?php

namespace Mooi\WallBundle\Entity;

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Mooi\WallBundle\Entity\Post
 */
class Filter
{
    
    private $subject;
    private $year;
    
    public function setSubject($subject)
    {
        
        $this->subject = $subject;
        
    }
    
    public function getSubject()
    {
        
        return $this->subject;
        
    }
    
    public function setYear($year)
    {
        
        $this->year = $year;
        
    }
    
    public function getYear()
    {
        
        return $this->year->format('Y');
        
    }

    
}
