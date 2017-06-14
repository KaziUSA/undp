<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IssueMapDistricts
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\IssueMapDistrictsRepository")
 */
class IssueMapDistricts
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
     * @ORM\ManyToOne(targetEntity="IssueMapName", inversedBy="issuemapdistricts")
     * @ORM\JoinColumn(name="issue_map_name_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $issueMapName;

    /**
     * @ORM\ManyToOne(targetEntity="District", inversedBy="issuemapdistricts")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $district;


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

