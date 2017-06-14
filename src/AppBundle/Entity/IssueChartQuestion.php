<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IssueChartQuestion
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class IssueChartQuestion
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="chartType", type="integer")
     */
    private $chartType;


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
     * @return IssueChartQuestion
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
     * Set chartType
     *
     * @param integer $chartType
     *
     * @return IssueChartQuestion
     */
    public function setChartType($chartType)
    {
        $this->chartType = $chartType;

        return $this;
    }

    /**
     * Get chartType
     *
     * @return integer
     */
    public function getChartType()
    {
        return $this->chartType;
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

    /* To fix: Object of class Proxies\__CG__\AppBundle\Entity\... could not be converted to string"). */
    public function __toString() {
        return $this->name;
    }
}

