<?php

namespace Mooi\WallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mooi\WallBundle\Entity\Reply
 */
class Reply
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $text
     */
    private $text;

    /**
     * @var datetime $time
     */
    private $time;

    /**
     * @var Mooi\WallBundle\Entity\Post
     */
    private $post;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     *
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set time
     *
     * @param datetime $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * Get time
     *
     * @return datetime 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set post
     *
     * @param Mooi\WallBundle\Entity\Post $post
     */
    public function setPost(\Mooi\WallBundle\Entity\Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get post
     *
     * @return Mooi\WallBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }
}