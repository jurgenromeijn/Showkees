<?php

namespace Mooi\WallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mooi\WallBundle\Entity\Post_has_subject
 */
class Post_has_subject
{
    /**
     * @var Mooi\WallBundle\Entity\Subject
     */
    private $subject;

    /**
     * @var Mooi\WallBundle\Entity\Post
     */
    private $post;


    /**
     * Set subject
     *
     * @param Mooi\WallBundle\Entity\Subject $subject
     */
    public function setSubject(\Mooi\WallBundle\Entity\Subject $subject)
    {
        $this->subject = $subject;
    }

    /**
     * Get subject
     *
     * @return Mooi\WallBundle\Entity\Subject 
     */
    public function getSubject()
    {
        return $this->subject;
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