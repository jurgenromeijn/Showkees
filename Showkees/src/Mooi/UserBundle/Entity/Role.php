<?php

namespace Mooi\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Mooi\UserBundle\Entity\Role
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity
 */
class Role
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=60)
     */
    private $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Mooi\UserBundle\Entity\User", mappedBy="role")
     */
    private $users;

    public function __construct()
    {
	
	$this->users = new ArrayCollection();
	
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
     * Set users
     *
     * @param ArrayCollection $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * Get users
     *
     * @return ArrayCollection 
     */
    public function getUsers()
    {
        return $this->users;
    }
    
}