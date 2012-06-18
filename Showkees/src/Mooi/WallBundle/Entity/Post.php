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
    * @var int $likes
    */
    private $likes = 0;
    
    /**
     * @var Mooi\UserBundle\Entity\User
     */
    private $users;

    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set like
     *
     * @param int $likes
     */
    public function setLikes($likes)
    {
        
        $this->likes = $likes;
        
    }

    /**
     * Get like
     *
     * @return int 
     */
    public function getLikes()
    {
        
        return $this->likes;
        
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
     * @var Mooi\WallBundle\Entity\Image
     */
    private $images;


    /**
     * Add images
     *
     * @param Mooi\WallBundle\Entity\Image $images
     */
    public function addImages(\Mooi\WallBundle\Entity\Image $images)
    {
        $this->images[] = $images;
    }

    /**
     * Get images
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add images
     *
     * @param Mooi\WallBundle\Entity\Image $images
     */
    public function addImage(\Mooi\WallBundle\Entity\Image $images)
    {
        $this->images[] = $images;
    }
    
    /**
     * @var Mooi\WallBundle\Entity\Subject
     */
    private $subject;


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
     * @var Mooi\WallBundle\Entity\Post
     */
    private $replies;

    /**
     * @var Mooi\WallBundle\Entity\Post
     */
    private $mainPosts;


    /**
     * Add replies
     *
     * @param Mooi\WallBundle\Entity\Post $replies
     */
    public function addReply(\Mooi\WallBundle\Entity\Post $replies)
    {
        $this->replies[] = $replies;
    }

    /**
     * Get replies
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getReplies()
    {
        return $this->replies;
    }

    /**
     * Get mainPosts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMainPosts()
    {
        
        return $this->mainPosts;
        
    }

    /**
     * Add replies
     *
     * @param Mooi\WallBundle\Entity\Post $replies
     */
    public function addPost(\Mooi\WallBundle\Entity\Post $replies)
    {
        $this->replies[] = $replies;
    }
            
    private $replyForm;
    
    public function setReplyForm($replyForm)
    {
        
        $this->replyForm = $replyForm;
        
    }
    
    public function getReplyForm()
    {
        
        return $this->replyForm;
        
    }
    /**
     * @var string $type
     */
    private $type;


    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
}