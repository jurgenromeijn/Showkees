<?php

namespace Mooi\UserBundle\Entity;

class User
{
    
    private $id;
    private $role;   
    private $first_name;
    private $last_name;
    private $preposition;
    private $email;
    private $password;
   
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
     * Set first_name
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set preposition
     *
     * @param string $preposition
     */
    public function setPreposition($preposition)
    {
        $this->preposition = $preposition;
    }

    /**
     * Get preposition
     *
     * @return string 
     */
    public function getPreposition()
    {
        return $this->preposition;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set role
     *
     * @param Mooi\UserBundle\Entity\Role $role
     */
    public function setRole(\Mooi\UserBundle\Entity\Role $role)
    {
        $this->role = $role;
    }

    /**
     * Get role
     *
     * @return Mooi\UserBundle\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
    }
}