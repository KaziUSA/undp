<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="key_findings_month", type="integer")
     */
    private $keyFindingsMonth;

    /**
     * @var string
     *
     * @ORM\Column(name="key_findings", type="text")
     */
    private $keyFindings;

    /**
     * @var string
     *
     * @ORM\Column(name="infographics_title", type="string", length=255, nullable=true)
     */
    private $infographicsTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="hrrp", type="text", nullable=true)
     */
    private $hrrp;

    /**
     * @var string
     *
     * @ORM\Column(name="district_id", type="text", nullable=true)
     */
    private $districtId;


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
     * Set infographicsTitle
     *
     * @param string $infographicsTitle
     *
     * @return IssueQuestion
     */
    public function setInfographicsTitle($infographicsTitle)
    {
        $this->infographicsTitle = $infographicsTitle;

        return $this;
    }

    /**
     * Get infographicsTitle
     *
     * @return string
     */
    public function getInfographicsTitle()
    {
        return $this->infographicsTitle;
    }

    /**
     * Set hrrp
     *
     * @param string $hrrp
     *
     * @return IssueQuestion
     */
    public function setHrrp($hrrp)
    {
        $this->hrrp = $hrrp;

        return $this;
    }

    /**
     * Get hrrp
     *
     * @return string
     */
    public function getHrrp()
    {
        return $this->hrrp;
    }

    /**
     * Set districtId
     *
     * @param string $districtId
     *
     * @return IssueQuestion
     */
    public function setDistrictId($districtId)
    {
        $this->districtId = $districtId;

        return $this;
    }

    /**
     * Get hrrp
     *
     * @return string
     */
    public function getDistrictId()
    {
        return $this->hrrp;
    }

    /* To fix: Object of class Proxies\__CG__\AppBundle\Entity\IssueQuestion could not be converted to string"). */
    public function __toString() {
        return $this->name;
    }
}

