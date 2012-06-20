<?php

namespace Mooi\WallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mooi\WallBundle\Entity\Notification
 */
class Notification
{
    
    const MESSAGE_WALL_OWN_MALE   = "heeft een bericht op zijn Showkees geplaatst!";
    const MESSAGE_WALL_OWN_FEMALE = "heeft een bericht op haar Showkees geplaatst!";
    const MESSAGE_WALL_OTHER      = "heeft een bericht op jouw Showkees geplaatst!";
    const MESSAGE_LIKE            = "vindt een post van jou leuk!";

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

    
    public function __construct()
    {
        $this->new  = true;
        $this->time = new \DateTime();
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
     * Set message
     *
     * @param text $message
     */
    public function setMessage($message, \Mooi\WallBundle\Entity\Post $post = null)
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
    /**
     * @var Mooi\WallBundle\Entity\Post
     */
    private $post;


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
    /**
     * @var string $quote
     */
    private $quote;


    /**
     * Set quote
     *
     * @param string $quote
     */
    public function setQuote(\Mooi\WallBundle\Entity\Post $post)
    {
        $this->quote = (strlen($post->getText()) > 50) ?
                            substr($post->getText(), 0, 50) . '...' :
                            $post->getText();
    }

    /**
     * Get quote
     *
     * @return string 
     */
    public function getQuote()
    {
        return $this->quote;
    }
}