<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=255, nullable=true)
     */
    private $icon;


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
     * Set icon
     *
     * @param string $icon
     *
     * @return IssueInfographics
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
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
}

