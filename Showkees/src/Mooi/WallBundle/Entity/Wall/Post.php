<?php

namespace Mooi\WallBundle\Entity\Wall;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mooi\WallBundle\Entity\Wall\Post
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