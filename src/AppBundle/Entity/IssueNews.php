<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * IssueNews
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class IssueNews
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @Assert\File(
     * maxSize="10737418240",
     * mimeTypes = {"image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *          "audio/mpeg"},
     * mimeTypesMessage = "Please upload a valid Image"
     * )
     */
    public $file;

    /**
     * @var string
     *
     * @ORM\Column(name="imageUrl", type="string", length=255, nullable=true)
     */
    private $imageUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="audioUrl", type="string", length=255, nullable=true)
     */
    private $audioUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="youtubeUrl", type="string", length=255, nullable=true)
     */
    private $youtubeUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="createdDate", type="string", length=255, nullable=true)
     */
    private $createdDate;

    /**
     * @var string
     *
     * @ORM\Column(name="updatedDate", type="string", length=255, nullable=true)
     */
    private $updatedDate;

    public $file_path = '/../../../uploads/issue/news/img';


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
     *
     * @return IssueNews
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set description
     *
     * @param string $description
     *
     * @return IssueNews
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return IssueNews
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }




    /**
     * Set audioUrl
     *
     * @param string $audioUrl
     *
     * @return IssueNews
     */
    public function setAudioUrl($audioUrl)
    {
        $this->audioUrl = $audioUrl;

        return $this;
    }

    /**
     * Get audioUrl
     *
     * @return string
     */
    public function getAudioUrl()
    {
        return $this->audioUrl;
    }




    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        //$avatarExt = pathinfo($file, PATHINFO_BASENAME);
        $avatarExt = $this->file->getClientOriginalName();

        //REVISED BY PRADEEP FOR DUPLICATE FILE REPLACEMENT PROBLEM
        $avatarExtension = $this->file->getClientOriginalExtension();
        $firstName = chop($avatarExt, ".".$avatarExtension);
        $avatarExt = $firstName."-".date("F-j-Y-H-i-s").".".$avatarExtension;
        //REVISION CODE ENDS HERE

        // $reversAv = strrev($avatarExt);

        // $avatarBase = $avatarExt->
        // check if we have an old image path

        $this->imageUrl = $avatarExt;

        /*if($avatarExtension == 'jpg' || $avatarExtension == 'png' || $avatarExtension == 'jpeg') {
            $this->imageUrl = $avatarExt;
        } elseif($avatarExtension == 'mpeg' || $avatarExtension == 'mp3') {
            $this->audioUrl = $avatarExt;
            var_dump($this->audioUrl);
        }*/

        
        /*if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = $avatarExt;
        }*/
    }

    public function getAbsolutePath()
    {
        return null === $this->imageUrl
            ? null
            : $this->getUploadRootDir().'/'.$this->imageUrl;
    }

    public function getWebPath()
    {
        return null === $this->imageUrl
            ? null
            : $this->getUploadDir().'/'.$this->imageUrl;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/issue/news/img';
    }

    protected function getAudioUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/uploads/issue/news/audio';
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            /*$filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->getFile()->getExtension();*/
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error

        //seperate upload directory for img and audio
        $avatarExtension = $this->file->getClientOriginalExtension();
        if($avatarExtension == 'jpg' || $avatarExtension == 'png' || $avatarExtension == 'jpeg') {
            // var_dump($this->getUploadRootDir());
            // var_dump($this);
            $this->getFile()->move($this->getUploadRootDir(), $this->imageUrl);
        } elseif($avatarExtension == 'mpeg' || $avatarExtension == 'mp3') {
            // var_dump($this->getAudioUploadRootDir());
            // var_dump($this);
            // var_dump($this->audioUrl);
            // var_dump($this->imageUrl);
            // var_dump($this->file->getClientOriginalName());
            $this->getFile()->move($this->getAudioUploadRootDir(), $this->imageUrl);
            //Tried to keep audio in audioUrl column of database
        }
        // exit();

        

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;

        //for flashbag message
        $_SESSION["profile_upload"] = "1";
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
         $file = $this->getAbsolutePath(); 
        if ($file) {
            $this->status=0;
        }
    }


    /**
     * Set youtubeUrl
     *
     * @param string $youtubeUrl
     *
     * @return IssueNews
     */
    public function setYoutubeUrl($youtubeUrl)
    {
        $this->youtubeUrl = $youtubeUrl;

        return $this;
    }

    /**
     * Get youtubeUrl
     *
     * @return string
     */
    public function getYoutubeUrl()
    {
        return $this->youtubeUrl;
    }

    /**
     * Set createdDate
     *
     * @param string $createdDate
     *
     * @return IssueNews
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return string
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set updatedDate
     *
     * @param string $updatedDate
     *
     * @return IssueNews
     */
    public function setUpdatedDate($updatedDate)
    {
        $this->updatedDate = $updatedDate;

        return $this;
    }

    /**
     * Get updatedDate
     *
     * @return string
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }
}

