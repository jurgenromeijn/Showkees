<?php

namespace Mooi\WallBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mooi\WallBundle\Entity\Image
 */
class Image
{
    
    private $file;
    
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var datetime $time
     */
    private $time;

    /**
     * @var string $extension
     */
    private $extension;

    /**
     * @var Mooi\WallBundle\Entity\Post
     */
    private $posts;
    
    // check this far to see whether we need to save the image
    private $fileSet = false;


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
     * Set extension
     *
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * Get extension
     *
     * @return string 
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Add posts
     *
     * @param Mooi\WallBundle\Entity\Post $posts
     */
    public function addPost(\Mooi\WallBundle\Entity\Post $posts)
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
    
    private $oldFile;
    
    /**
     * Set file
     *
     * @param file $file
     */
    public function setFile($file)
    {
        $this->oldFile = $this->getAbsolutePath();
        $this->file    = $file;
        $this->fileSet = true;
        $this->time    = new \DateTime();
    }

    /**
     * Get file
     *
     * @return file 
     */
    public function getFile()
    {
        return $this->file;
    }
    
    public function isFileSet()
    {
        return $this->fileSet;
    }

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }
    
        private $filenameForRemove;

    public function preUpload()
    {
        if (null !== $this->file) {
            $this->extension = $this->file->guessExtension();
            $this->name      = $this->file->getClientOriginalName();
            if($this->oldFile !== null && file_exists($this->oldFile))
            {
                unlink($this->oldFile);
            }
        }
    }

    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does
        $this->file->move($this->getUploadRootDir(), $this->id.'_'.$this->time->getTimestamp().'.'.$this->file->guessExtension());

        unset($this->file);
    }

    public function storeFilenameForRemove()
    {
        $this->filenameForRemove = $this->getAbsolutePath();
    }

    public function removeUpload()
    {
        if ($this->filenameForRemove) {
            unlink($this->filenameForRemove);
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->extension ? null : $this->getUploadRootDir().'/'.$this->id.'_'.$this->time->getTimestamp().'.'.$this->extension;
    }

    public function getWebPath()
    {
        return null === $this->extension ? null : $this->getUploadDir().'/'.$this->id.'_'.$this->time->getTimestamp().'.'.$this->extension;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads';
    }

}