<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IssuePeople
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\IssuePeopleRepository")
 */
class IssuePeople
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
     * @ORM\ManyToOne(targetEntity="District", inversedBy="issuepeople")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $districtId;

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
     * @return IssuePeople
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
     * @return IssuePeople
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
     * Set districtId
     *
     * @param \AppBundle\Entity\District $districtId
     *
     * @return districtId
     */
    public function setDistrictId(\AppBundle\Entity\District $districtId = null)
    {
        $this->districtId = $districtId;

        return $this;
    }

    /**
     * Get districtId
     *
     * @return \AppBundle\Entity\District
     */
    public function getDistrictId()
    {
        return $this->districtId;
    }
}

