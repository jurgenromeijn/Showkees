<?php

namespace Mooi\WallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mooi\WallBundle\Entity\Notification
 */
class Notification
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var text $message
     */
    private $message;

    /**
     * @var boolean $new
     */
    private $new;

    /**
     * @var datetime $time
     */
    private $time;

    /**
     * @var Mooi\UserBundle\Entity\User
     */
    private $owner;

    /**
     * @var Mooi\UserBundle\Entity\User
     */
    private $about;


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
     * Set message
     *
     * @param text $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Get message
     *
     * @return text 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set new
     *
     * @param boolean $new
     */
    public function setNew($new)
    {
        $this->new = $new;
    }

    /**
     * Get new
     *
     * @return boolean 
     */
    public function getNew()
    {
        return $this->new;
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
     * Set owner
     *
     * @param Mooi\UserBundle\Entity\User $owner
     */
    public function setOwner(\Mooi\UserBundle\Entity\User $owner)
    {
        $this->owner = $owner;
    }

    /**
     * Get owner
     *
     * @return Mooi\UserBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set about
     *
     * @param Mooi\UserBundle\Entity\User $about
     */
    public function setAbout(\Mooi\UserBundle\Entity\User $about)
    {
        $this->about = $about;
    }

    /**
     * Get about
     *
     * @return Mooi\UserBundle\Entity\User 
     */
    public function getAbout()
    {
        return $this->about;
    }
}