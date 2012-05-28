<?php

namespace Mooi\WallBundle\Entity;

/**
 * Mooi\WallBundle\Entity\Post
 */
class Post
{
    /**
     * @var integer $id
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}