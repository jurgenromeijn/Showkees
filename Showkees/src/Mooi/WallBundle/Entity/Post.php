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
    
    /*public function setSubjects(ArrayCollection $subjects)
    {
        $this->subjects = $subjects;
    }*/
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
     * @var Mooi\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param Mooi\UserBundle\Entity\User $user
     */
    public function setUser(\Mooi\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Mooi\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @var Mooi\UserBundle\Entity\User
     */
    private $user_sender;

    /**
     * @var Mooi\UserBundle\Entity\User
     */
    private $user_wall_owner;


    /**
     * Set user_sender
     *
     * @param Mooi\UserBundle\Entity\User $userSender
     */
    public function setUserSender(\Mooi\UserBundle\Entity\User $userSender)
    {
        $this->user_sender = $userSender;
    }

    /**
     * Get user_sender
     *
     * @return Mooi\UserBundle\Entity\User 
     */
    public function getUserSender()
    {
        return $this->user_sender;
    }

    /**
     * Set user_wall_owner
     *
     * @param Mooi\UserBundle\Entity\User $userWallOwner
     */
    public function setUserWallOwner(\Mooi\UserBundle\Entity\User $userWallOwner)
    {
        $this->user_wall_owner = $userWallOwner;
    }

    /**
     * Get user_wall_owner
     *
     * @return Mooi\UserBundle\Entity\User 
     */
    public function getUserWallOwner()
    {
        return $this->user_wall_owner;
    }
}