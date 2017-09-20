<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * IssueQuestion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\IssueQuestionRepository")
 */
class IssueQuestion
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
     * @ORM\ManyToOne(targetEntity="IssueType", inversedBy="issuequestion")
     * @ORM\JoinColumn(name="issue_type_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $issueType;


    /**
     * @var integer
     *
     * @ORM\Column(name="key_findings_month", type="integer", nullable=true)
     */
    private $keyFindingsMonth;

    /**
     * @var string
     *
     * @ORM\Column(name="key_findings", type="text", nullable=true)
     */
    private $keyFindings;


    


    /**
     * @ORM\ManyToOne(targetEntity="IssueMapName", inversedBy="issuequestion")
     * @ORM\JoinColumn(name="issue_map_name_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $issueMapName;


    /**
     * @var string
     *
     * @ORM\Column(name="image_title", type="string", length=255, nullable=true)
     */
    private $imageTitle;

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
     * @ORM\Column(name="image_url", type="string", length=255, nullable=true)
     */
    private $imageUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="image_desc", type="text", nullable=true)
     */
    private $imageDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="image_credit", type="string", length=255, nullable=true)
     */
    private $imageCredit;



    public $file_path = '/../../../uploads/issue/img';


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
     * @return IssueQuestion
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
     * Set issueType
     *
     * @param \AppBundle\Entity\IssueType $issueType
     *
     * @return issueType
     */
    public function setIssueType(\AppBundle\Entity\IssueType $issueType = null)
    {
        $this->issueType = $issueType;

        return $this;
    }

    /**
     * Get issueType
     *
     * @return \AppBundle\Entity\IssueType
     */
    public function getIssueType()
    {
        return $this->issueType;
    }


    /**
     * Set keyFindingsMonth
     *
     * @param integer $keyFindingsMonth
     *
     * @return IssueQuestion
     */
    public function setKeyFindingsMonth($keyFindingsMonth)
    {
        $this->keyFindingsMonth = $keyFindingsMonth;

        return $this;
    }

    /**
     * Get keyFindingsMonth
     *
     * @return integer
     */
    public function getKeyFindingsMonth()
    {
        return $this->keyFindingsMonth;
    }

    /**
     * Set keyFindings
     *
     * @param string $keyFindings
     *
     * @return IssueQuestion
     */
    public function setKeyFindings($keyFindings)
    {
        $this->keyFindings = $keyFindings;

        return $this;
    }

    /**
     * Get keyFindings
     *
     * @return string
     */
    public function getKeyFindings()
    {
        return $this->keyFindings;
    }

    





    /**
     * Set issueMapName
     *
     * @param \AppBundle\Entity\IssueMapName $issueMapName
     *
     * @return issueMapName
     */
    public function setIssueMapName(\AppBundle\Entity\IssueMapName $issueMapName = null)
    {
        $this->issueMapName = $issueMapName;

        return $this;
    }

    /**
     * Get issueMapName
     *
     * @return \AppBundle\Entity\IssueMapName
     */
    public function getIssueMapName()
    {
        return $this->issueMapName;
    }

    /**
     * Set imageTitle
     *
     * @param string $imageTitle
     *
     * @return IssueQuestion
     */
    public function setImageTitle($imageTitle)
    {
        $this->imageTitle = $imageTitle;

        return $this;
    }

    /**
     * Get imageTitle
     *
     * @return string
     */
    public function getImageTitle()
    {
        return $this->imageTitle;
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

        
        /*if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = $avatarExt;
        }*/
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return IssueQuestion
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
        return 'uploads/issue/img';
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
        var_dump($this->imageUrl); exit();
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
     * Set imageDesc
     *
     * @param string $imageDesc
     *
     * @return IssueQuestion
     */
    public function setImageDesc($imageDesc)
    {
        $this->imageDesc = $imageDesc;

        return $this;
    }

    /**
     * Get imageDesc
     *
     * @return string
     */
    public function getImageDesc()
    {
        return $this->imageDesc;
    }


    /**
     * Set imageCredit
     *
     * @param string $imageCredit
     *
     * @return IssueQuestion
     */
    public function setImageCredit($imageCredit)
    {
        $this->imageCredit = $imageCredit;

        return $this;
    }

    /**
     * Get imageCredit
     *
     * @return string
     */
    public function getImageCredit()
    {
        return $this->imageCredit;
    }

    /* To fix: Object of class Proxies\__CG__\AppBundle\Entity\IssueQuestion could not be converted to string"). */
    public function __toString() {
        return $this->name;
    }
}

