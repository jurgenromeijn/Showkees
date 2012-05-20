<?php

namespace Mooi\UserBundle\Entity;

class Role
{
    
    private $id;
    private $name;
    private $internal_name;
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
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
     * Add users
     *
     * @param Mooi\UserBundle\Entity\User $users
     */
    public function addUser(\Mooi\UserBundle\Entity\User $user)
    {
        $this->users[] = $user;
    }

    /**
     * Set internal_name
     *
     * @param string $internalName
     */
    public function setInternalName($internalName)
    {
        $this->internal_name = $internalName;
    }

    /**
     * Get internal_name
     *
     * @return string 
     */
    public function getInternalName()
    {
        return $this->internal_name;
    }
    
    public function __toString()
    {
        
        return $this->getName();
        
    }
    
}