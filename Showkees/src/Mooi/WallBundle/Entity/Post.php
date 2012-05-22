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
     * @var integer $sender_id
     */
    private $sender_id;
    
    /**
     * @var integer $$wall_owner_id
     */
    private $wall_owner_id;
    
    /**
     * @var string $text
     */
    private $text;

    /**
     * @var date $time
     */
    private $time;

    /**
     * @var Mooi\WallBundle\Entity\User
     */
    private $users;


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
     * Set sender_id
     *
     * @param integer $senderId
     */
    public function setSenderId($senderId)
    {
        $this->sender_id = $senderId;
    }

    /**
     * Get sender_id
     *
     * @return integer 
     */
    public function getSenderId()
    {
        return $this->sender_id;
    }
    
    /**
     * Set sender_id
     *
     * @param integer $senderId
     */
    public function setWallOwnerId($senderId)
    {
        $this->sender_id = $senderId;
    }

    /**
     * Get sender_id
     *
     * @return integer 
     */
    public function getWallOwnerId()
    {
        return $this->sender_id;
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
     * Set users
     *
     * @param Mooi\WallBundle\Entity\User $users
     */
    public function setUsers(\Mooi\WallBundle\Entity\User $users)
    {
        $this->users = $users;
    }

    /**
     * Get users
     *
     * @return Mooi\WallBundle\Entity\User 
     */
    public function getUsers()
    {
        return $this->users;
    }
    
    private function covertTime($timeSet)
    {
        $timeBetween = time() - $timeSet;

        return $timeBetween;
    }

    private function updateTime($timeSet)
    {
        $diff = covertTime($timeSet);
        $diff += 7200;

        if(year($diff))
        {
            $count = floor($diff/31556926);
            return $count." jaar geleden";
        }
        if(month($diff))
        {
            $count = floor($diff/2629743);
            return ($count == 1) ? "1 maand geleden" : $count . " maanden geleden";
        }
        if(day($diff))
        {
            $count = floor($diff/86400);
            return ($count == 1) ? "1 dag geleden" : $count . " dagen geleden";
        }
        if(hour($diff))
        {
            $count = floor($diff/3600);
            return $count." uur geleden";
        }
        if(minute($diff))
        {
            $count = floor($diff/60);
            return ($count == 1) ? "1 minuut geleden" : $count . " minuten geleden";
        }
        if(second($diff))
        {
            $count = floor($diff);
            return $count . ' seconde geleden';
        } 
    }
        
    private function year($stamp)
    {
        
        return $stamp > 31556926;
        
    }
    private function month($stamp)
    {
        
        return $stamp > 2629743 && $stamp < 31556926;
        
    }
    private function day($stamp)
    {
        
        return $stamp > 86400 && $stamp < 2629743;
        
    }
    private function hour($stamp)
    {
        
        return $stamp > 3600 && $stamp < 86400;
        
    }
    private function minute($stamp)
    {
        
        return $stamp > 60 && $stamp < 3600;
        
    }
    private function second($stamp)
    {
        
        return $stamp < 60;
        
    }
    
}