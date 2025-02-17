<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Document
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Document
{
     private $temp;
    /**
     * @Assert\File(
     * maxSize="10737418240",
     * mimeTypes = {"application/pdf", "application/x-pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"},
     * mimeTypesMessage = "Please upload a valid Document"
     * )
     */
    public $file;

    /**
     * @Assert\File(
     * maxSize="10737418240",
     * mimeTypes = {"image/png",
     *          "image/jpeg",
     *          "image/jpg"},
     * mimeTypesMessage = "Please upload a valid Image"
     * )
     */
    public $imgFile;

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
     * @var date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="imgUrl", type="string", length=255, nullable=true)
     */
    private $imgUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=10, nullable=true)
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="district", type="string", length=255, nullable=true)
     */
    private $district = null;

    /**
     * @ORM\ManyToOne(targetEntity="DocumentType", inversedBy="documents")
     * @ORM\JoinColumn(name="document_type_id", referencedColumnName="id")
     */
    protected $documenttype;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status=1;
    public $file_path = '/../../../uploads/documents/';
    public $img_file_path = '/../../../uploads/documents/thumbs/';

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
        $this->path = $avatarExt;

        // var_dump($this->path);
        // exit();

        /*if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = $avatarExt;
        }*/
    }



    public function getImgFile()
    {
        return $this->imgFile;
    }

    public function setImgFile(UploadedFile $imgFile = null)
    {
        $this->imgFile = $imgFile;
        //$avatarExt = pathinfo($imgFile, PATHINFO_BASENAME);
        $avatarExt = $this->imgFile->getClientOriginalName();

        //REVISED BY PRADEEP FOR DUPLICATE FILE REPLACEMENT PROBLEM
        $avatarExtension = $this->imgFile->getClientOriginalExtension();
        $firstName = chop($avatarExt, ".".$avatarExtension);
        $avatarExt = $firstName."-".date("F-j-Y-H-i-s").".".$avatarExtension;
        //REVISION CODE ENDS HERE

        // $reversAv = strrev($avatarExt);

        // $avatarBase = $avatarExt->
        // check if we have an old image imgUrl
        $this->imgUrl = $avatarExt;
        
        /*var_dump($this->imgUrl);
        exit();*/

        
        /*if (isset($this->imgUrl)) {
            // store the old name to delete after the update
            $this->temp = $this->imgUrl;
            $this->imgUrl = null;
        } else {
            $this->imgUrl = $avatarExt;
        }*/
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
     *
     * @return Document
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
     * @return Document
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
     * Set status
     *
     * @param integer $status
     *
     * @return Document
     */
    public function setStatus($status)
    {
        return $this->status = $status;
    }
    /**
     * Get status
     *
     * @return status
     */
    public function getStatus()
    {
        return $this->status;
    }

     /* Set date
     *
     * @param date $date
     *
     * @return Document
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    
    /* Get date
     *
     * @return date
     */
    public function getDate()
    {
        return $this->date;
    }

     /* Set path
     *
     * @param path $path
     *
     * @return Document
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }


    
    /* Get path
     *
     * @return path
     */
     public function getPath()
    {
        return $this->path;
            
    }

     /* Set path
     *
     * @param path $imgUrl
     *
     * @return Document
     */
    public function setImgUrl($imgUrl)
    {
        $this->imgUrl = $imgUrl;

        return $this;
    }


    
    /* Get imgUrl
     *
     * @return imgUrl
     */
     public function getImgUrl()
    {
        return $this->imgUrl;
            
    }

     /* Set language
     *
     * @param language $language
     *
     * @return Document
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $language;
    }


    
    /* Get language
     *
     * @return language
     */
     public function getLanguage()
    {
        return $this->language;
            
    }

     /* Set district
     *
     * @param district $district
     *
     * @return Document
     */
    public function setDistrict($district)
    {
        $this->district = $district;

        return $district;
    }


    
    /* Get district
     *
     * @return district
     */
     public function getDistrict()
    {
        return $this->district;
            
    }

     /* Set type
     *
     * @param type $type
     *
     * @return Document
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /* Get type
     *
     * @return type
     */
     public function getType()
    {
        return $this->type;
            
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }
    
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
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

        if(isset($this->path)) {
            var_dump($this->path);
        }

        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;

        //for flashbag message
        $_SESSION["document_upload"] = "1";
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

    protected function getUploadRootDirImgUrl()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDirImgUrl();
    }
    
    public function getAbsoluteImgUrl()
    {
        return null === $this->imgUrl
            ? null
            : $this->getUploadRootDirImgUrl().'/'.$this->imgUrl;
    }

    public function getWebImgUrl()
    {
        return null === $this->imgUrl
            ? null
            : $this->getUploadDirImgUrl().'/'.$this->imgUrl;
    }

    protected function getUploadDirImgUrl()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents/thumbs';
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUploadImgUrl()
    {
        if (null !== $this->getImgFile()) {
            // do whatever you want to generate a unique name
            /*$filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->getFile()->getExtension();*/
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function uploadImgUrl()
    {
        if (null === $this->getImgFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        
        if(isset($this->imgUrl)) {
            var_dump($this->imgUrl);
        }
        var_dump($this->getUploadRootDirImgUrl() );
        // exit();


        $this->getImgFile()->move($this->getUploadRootDirImgUrl(), $this->imgUrl);

        /*var_dump($this->temp);
        exit();*/

        // check if we have an old image
        if (isset($this->tempImgUrl)) {//TOKNOW: can we use single tempImgUrl...
            // delete the old image
            unlink($this->getUploadRootDirImgUrl().'/'.$this->tempImgUrl);
            // clear the tempImgUrl image path
            $this->tempImgUrl = null;
        }
        $this->imgFile = null;

        //for flashbag message
        $_SESSION["document_upload"] = "1";
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUploadImgUrl()
    {
        $imgFile = $this->getAbsolutePathImgUrl(); 
        if ($imgFile) {
            $this->status=0;
        }
    }

    /**
     * Set documenttype
     *
     * @param \AppBundle\Entity\DocumentType $documentType
     *
     * @return Document
     */
    public function setDocumentType(\AppBundle\Entity\DocumentType $documentType = null)
    {
        $this->documenttype = $documentType;

        return $this;
    }

    /**
     * Get documentType
     *
     * @return \AppBundle\Entity\DocumentType
     */
    public function getDocumentType()
    {
        return $this->documenttype;
    }
}

