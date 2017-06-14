<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IssueMapSayings
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class IssueMapSayings
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
     * @ORM\ManyToOne(targetEntity="IssueQuestion", inversedBy="issuepeople")
     * @ORM\JoinColumn(name="issue_question_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $issueQuestion;


    /**
     * @ORM\ManyToOne(targetEntity="District", inversedBy="issuemapdistricts")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $district;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="saying", type="text")
     */
    private $saying;

    /**
     * @var string
     *
     * @ORM\Column(name="hrrp", type="text", nullable=true)
     */
    private $hrrp;


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
     * Set location
     *
     * @param string $location
     *
     * @return IssueMapSayings
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set saying
     *
     * @param string $saying
     *
     * @return IssueMapSayings
     */
    public function setSaying($saying)
    {
        $this->saying = $saying;

        return $this;
    }

    /**
     * Get saying
     *
     * @return string
     */
    public function getSaying()
    {
        return $this->saying;
    }

    /**
     * Set hrrp
     *
     * @param string $hrrp
     *
     * @return IssueMapSayings
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
     * Set issueQuestion
     *
     * @param \AppBundle\Entity\IssueQuestion $issueQuestion
     *
     * @return issueQuestion
     */
    public function setIssueQuestion(\AppBundle\Entity\IssueQuestion $issueQuestion = null)
    {
        $this->issueQuestion = $issueQuestion;

        return $this;
    }

    /**
     * Get issueQuestion
     *
     * @return \AppBundle\Entity\IssueQuestion
     */
    public function getIssueQuestion()
    {
        return $this->issueQuestion;
    }

    

    /**
     * Set district
     *
     * @param \AppBundle\Entity\District $district
     *
     * @return district
     */
    public function setDistrict(\AppBundle\Entity\District $district = null)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district
     *
     * @return \AppBundle\Entity\District
     */
    public function getDistrict()
    {
        return $this->district;
    }
}

