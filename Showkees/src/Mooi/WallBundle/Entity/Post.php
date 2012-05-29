<?php

namespace Mooi\WallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string $text
     */
    private $text;

    /**
     * @var date $time
     */
    private $time;

    /**
     * @var Mooi\UserBundle\Entity\User
     */
    private $users;

    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * @param date $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * Get time
     *
     * @return date 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Add users
     *
     * @param Mooi\UserBundle\Entity\User $users
     */
    public function addUser(\Mooi\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;
    }

    /**
     * Get users
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
    /**
     * @var Mooi\WallBundle\Entity\Post_has_subject
     */
    private $subjects;


    /**
     * Add subjects
     *
     * @param Mooi\WallBundle\Entity\Post_has_subject $subjects
     */
    public function addPost_has_subject(\Mooi\WallBundle\Entity\Post_has_subject $subjects)
    {
        $this->subjects[] = $subjects;
    }

    /**
     * Get subjects
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSubjects()
    {
        return $this->subjects;
    }
    
    /**
     * @var Mooi\WallBundle\Entity\post_has_subject
     */
    private $posts_has_subjets;


    /**
     * Add posts_has_subjets
     *
     * @param Mooi\WallBundle\Entity\post_has_subject $postsHasSubjets
     */
    public function addpost_has_subject(\Mooi\WallBundle\Entity\post_has_subject $postsHasSubjets)
    {
        $this->posts_has_subjets[] = $postsHasSubjets;
    }

    /**
     * Get posts_has_subjets
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPostsHasSubjets()
    {
        return $this->posts_has_subjets;
    }
}