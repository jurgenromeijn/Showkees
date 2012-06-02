<?php

namespace Mooi\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, \Serializable
{
    
    protected $id;
    protected $role;   
    protected $first_name;
    protected $last_name;
    protected $preposition;
    protected $email;
    protected $salt;
    protected $password;
    protected $is_active;
    protected $date;

    public function __construct()
    {
        $this->is_active = true;
        $this->salt      = md5(uniqid(null, true));
        $this->date      = new \DateTime();
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

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set is_active
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;
    }

    /**
     * Get is_active
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->is_active;
    }
    
    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array("ROLE_USER");
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @inheritDoc
     */
    public function equals(UserInterface $user)
    {
        return $this->getUsername() === $user->getUsername();
    }    

    /**
     * Set date
     *
     * @param datetime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return datetime 
     */
    public function getDate()
    {
        return $this->date;
    }
    
    public function serialize()
    {
        
        return serialize($this->id);
        
    }

    public function unserialize($data)
    {
        $this->id = unserialize($data);
    }
    
    public function getFullName()
    {
        
        $fullName = $this->first_name;
        $fullName .= (!empty($this->preposition)) ? 
            '' + $this->preposition + ' ' :
            ' ';
        $fullName .= $this->last_name;
        
        return $fullName;
        
    }

    /**
     * @var Mooi\UserBundle\Entity\Post
     */
    private $post;


    /**
     * Set post
     *
     * @param Mooi\UserBundle\Entity\Post $post
     */
    public function setPost(\Mooi\UserBundle\Entity\Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get post
     *
     * @return Mooi\UserBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }
    /**
     * @var Mooi\UserBundle\Entity\Post
     */
    private $posts;


    /**
     * Add posts
     *
     * @param Mooi\UserBundle\Entity\Post $posts
     */
    public function addPost(\Mooi\UserBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;
    }

    /**
     * Get posts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPosts()
    {
        return $this->posts;
    }
}