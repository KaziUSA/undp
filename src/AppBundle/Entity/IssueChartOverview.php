<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IssueChartOverview
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class IssueChartOverview
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
     * @ORM\ManyToOne(targetEntity="IssueType", inversedBy="issuequestion")
     * @ORM\JoinColumn(name="issue_type_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $issueType;

    /**
     * @ORM\ManyToOne(targetEntity="District", inversedBy="issuemapdistricts")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $district;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;


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
     * Set value
     *
     * @param string $value
     *
     * @return IssueChartOverview
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

