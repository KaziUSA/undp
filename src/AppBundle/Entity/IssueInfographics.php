<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * IssueInfographics
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\IssueInfographicsRepository")
 */
class IssueInfographics
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
     * @ORM\ManyToOne(targetEntity="IssueInfographicsTitle", inversedBy="issueinfographics")
     * @ORM\JoinColumn(name="issue_infographics_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $issueInfographicsTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * @Assert\File(
     * maxSize="10737418240",
     * mimeTypes = {"image/png",
     *          "image/jpeg",
     *          "image/jpg"},
     * mimeTypesMessage = "Please upload a valid Image"
     * )
     */
    public $file;

    /**
     * @var string
     *
     * @ORM\Column(name="imageUrl", type="string", length=255, nullable=true)
     */
    private $imageUrl;//file_image or value (for %)

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
     */
    private $value;

    public $file_path = '/../../../uploads/issue/infographics';


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
     * Set description
     *
     * @param string $description
     *
     * @return IssueInfographics
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
     * Set issueInfographicsTitle
     *
     * @param \AppBundle\Entity\IssueInfographicsTitle $issueInfographicsTitle
     *
     * @return issueInfographicsTitle
     */
    public function setIssueInfographicsTitle(\AppBundle\Entity\IssueInfographicsTitle $issueInfographicsTitle = null)
    {
        $this->issueInfographicsTitle = $issueInfographicsTitle;

        return $this;
    }

    /**
     * Get issueInfographicsTitle
     *
     * @return \AppBundle\Entity\IssueInfographicsTitle
     */
    public function getIssueInfographicsTitle()
    {
        return $this->issueInfographicsTitle;
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

        // var_dump($this->imageUrl);exit();

        
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
        return 'uploads/issue/infographics';
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

        // var_dump('a');
        // var_dump($this->imageUrl);//exit();

        $this->getFile()->move($this->getUploadRootDir(), $this->imageUrl);

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
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return IssueInfographics
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
     * Set value
     *
     * @param string $value
     *
     * @return IssueInfographics
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}

