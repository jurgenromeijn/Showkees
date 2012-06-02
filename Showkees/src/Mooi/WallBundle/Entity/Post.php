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
    private $sender_users;

    /**
     * @var Mooi\UserBundle\Entity\User
     */
    private $wall_owner_users;


    /**
     * Set sender_users
     *
     * @param Mooi\UserBundle\Entity\User $senderUsers
     */
    public function setSenderUsers(\Mooi\UserBundle\Entity\User $senderUsers)
    {
        $this->sender_users = $senderUsers;
    }

    /**
     * Get sender_users
     *
     * @return Mooi\UserBundle\Entity\User 
     */
    public function getSenderUsers()
    {
        return $this->sender_users;
    }

    /**
     * Set wall_owner_users
     *
     * @param Mooi\UserBundle\Entity\User $wallOwnerUsers
     */
    public function setWallOwnerUsers(\Mooi\UserBundle\Entity\User $wallOwnerUsers)
    {
        $this->wall_owner_users = $wallOwnerUsers;
    }

    /**
     * Get wall_owner_users
     *
     * @return Mooi\UserBundle\Entity\User 
     */
    public function getWallOwnerUsers()
    {
        return $this->wall_owner_users;
    }
}