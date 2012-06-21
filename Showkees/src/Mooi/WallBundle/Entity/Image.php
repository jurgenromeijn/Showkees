<?php

namespace Mooi\WallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mooi\WallBundle\Entity\Image
 */
class Image
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;
    
    /**
     * @var file 
     */
    private $file;
    
    /**
     * @var datetime $time
     */
    private $time;
    
    
    /**
     * @var string $url
     */
    private $url;

    /**
     * Get id
     *
     * @return integer 
     */
    
    /**
     * @var Mooi\WallBundle\Entity\Post
     */
    private $posts;


    /**
     * Set posts
     *
     * @param Mooi\WallBundle\Entity\Post $posts
     */
    public function setPosts(\Mooi\WallBundle\Entity\Post $posts)
    {
        $this->posts = $posts;
    }

    /**
     * Get posts
     *
     * @return Mooi\WallBundle\Entity\Post 
     */
    public function getPosts()
    {
        return $this->posts;
    }
    
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
    

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
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
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    public $path;

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return '../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads';
    }
    
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->file) {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the target filename to move to
        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

        // set the path property to the filename where you'ved saved the file
        $this->path = $this->file->getClientOriginalName();
        $this->setUrl($this->path);

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }
    
}