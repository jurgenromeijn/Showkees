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
    public function setTime(\DateTime $time)
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
     * @var Mooi\UserBundle\Entity\User
     */
    private $sender;

    /**
     * @var Mooi\UserBundle\Entity\User
     */
    private $wall_owner;


    /**
     * Set sender
     *
     * @param Mooi\UserBundle\Entity\User $sender
     */
    public function setSender(\Mooi\UserBundle\Entity\User $sender)
    {
        $this->sender = $sender;
    }

    /**
     * Get sender
     *
     * @return Mooi\UserBundle\Entity\User 
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set wall_owner
     *
     * @param Mooi\UserBundle\Entity\User $wallOwner
     */
    public function setWallOwner(\Mooi\UserBundle\Entity\User $wallOwner)
    {
        $this->wall_owner = $wallOwner;
    }

    /**
     * Get wall_owner
     *
     * @return Mooi\UserBundle\Entity\User 
     */
    public function getWallOwner()
    {
        return $this->wall_owner;
    }
    /**
     * @var Mooi\WallBundle\Entity\Subject
     */
    public $subjects;


    /**
     * Add subjects
     *
     * @param Mooi\WallBundle\Entity\Subject $subjects
     */
    public function addSubject(\Mooi\WallBundle\Entity\Subject $subjects)
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
     * @var Mooi\WallBundle\Entity\Subject
     */
    private $images;


    /**
     * Add subjects
     *
     * @param Mooi\WallBundle\Entity\Subject $subjects
     */
    public function addImages(\Mooi\WallBundle\Entity\Image $images)
    {
        $this->images[] = $images;
    }

    /**
     * Get subjects
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
    
    
    
}