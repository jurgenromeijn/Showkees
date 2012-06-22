<?php

namespace Mooi\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use \Doctrine\Common\Collections\ArrayCollection;

class User implements UserInterface, \Serializable
{
    
    const GENDER_MALE = 'man';
    const GENDER_FEMALE = 'vrouw'; 

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
    protected $username;
    protected $gender;
    protected $teachers;
    protected $students;
    protected $style;
    protected $notifications;
    protected $notifications_about;
    
    public function __construct()
    {
        $this->is_active           = true;
        $this->salt                = md5(uniqid(null, true));
        $this->date                = new \DateTime();
        $this->teachers            = new ArrayCollection();
        $this->students            = new ArrayCollection();
        $this->notifications       = new ArrayCollection();
        $this->notifications_about = new ArrayCollection();
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
     * Set gender
     *
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
        
        //Set style based on gender for new accounts
        if(empty($this->style) && $gender == self::GENDER_MALE)
        {
            $this->style = "blue";
        }
        elseif(empty($this->style) && $gender == self::GENDER_FEMALE)
        {
            $this->style = "pink";
        }
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
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
        return $this->username;
    }
    
    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array($this->getRole()->getInternalName());
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
            ' ' . $this->preposition . ' ' :
            ' ';
        $fullName .= $this->last_name;
        
        return $fullName;
        
    }
    /**
     * @var Mooi\WallBundle\Entity\Post
     */
    private $wall_owner_posts;

    /**
     * @var Mooi\WallBundle\Entity\Post
     */
    private $sender_id_posts;


    /**
     * Get wall_owner_posts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getWallOwnerPosts()
    {
        return $this->wall_owner_posts;
    }

    /**
     * Get sender_id_posts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSenderIdPosts()
    {
        return $this->sender_id_posts;
    }

    /**
     * Add wall_owner_posts
     *
     * @param Mooi\WallBundle\Entity\Post $wallOwnerPosts
     */
    public function addPost(\Mooi\WallBundle\Entity\Post $wallOwnerPosts)
    {
        $this->wall_owner_posts[] = $wallOwnerPosts;
    }


    /**
     * Add students
     *
     * @param Mooi\UserBundle\Entity\User $students
     */
    public function addUser(\Mooi\UserBundle\Entity\User $students)
    {
        $this->students[] = $students;
    }

    /**
     * Get students
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * Get teachers
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTeachers()
    {
        return $this->teachers;
    }
    /**
     * Set style
     *
     * @param string $style
     */
    public function setStyle($style)
    {
        $this->style = $style;
    }

    /**
     * Get style
     *
     * @return string 
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Get notifications
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getNotifications($ammount = 0)
    {
                
        if($ammount > 0)
        {
            
            return $this->notifications->slice(0, $ammount);
            
        }
        else
        {
        
            return $this->notifications;
        
        }
        
    }

    /**
     * Get notifications_about
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getNotificationsAbout()
    {
        return $this->notifications_about;
    }

    /**
     * Add notifications
     *
     * @param Mooi\WallBundle\Entity\Notification $notifications
     */
    public function addNotification(\Mooi\WallBundle\Entity\Notification $notifications)
    {
        $this->notifications[] = $notifications;
    }
    
    public function getNewNotificationsAmmount()
    {
        
        $newNotifications = 0;
        
        foreach ($this->notifications as $notification) 
        {
            
            if($notification->getNew() == true)
            {
                
                $newNotifications++;
                
            }
            else
            {
                
                break;
                
            }
            
        }
        
        return $newNotifications;
        
    }
    
    public function hasWallPermisions($name = null)
    {
        
        $access = false;
        
        if($name == $this->getUserName())
        { 
            
            return true;
            
        }
        
        $userRole = $this->getRole()->getInternalName();
        
        switch ($userRole) 
        {
            case 'ROLE_SUPERADMIN':
                $access = true;
                break;
            case 'ROLE_ADMIN':
                $access = true;
                break;
            case 'ROLE_TEACHER':
                $access = true;
                break;
            case 'ROLE_STUDENT':
                $access = false;
                break;
            default:
                $access = false;
            break; 

        }
        
        
        return $access;
        
    }
    
    /**
     * @var Mooi\WallBundle\Entity\Image
     */
    private $avatar;


    /**
     * Set avatar
     *
     * @param Mooi\WallBundle\Entity\Image $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * Get avatar
     *
     * @return Mooi\WallBundle\Entity\Image 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
}