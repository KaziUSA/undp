<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IssueChartOption
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class IssueChartOption
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
     * @ORM\ManyToOne(targetEntity="IssueChartQuestion", inversedBy="issuechartoption")
     * @ORM\JoinColumn(name="issue_chart_question_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $issueChartQuestion;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
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
     * Set name
     *
     * @param string $name
     *
     * @return IssueChartOption
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
     * Set value
     *
     * @param string $value
     *
     * @return IssueChartOption
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
     * Set issueChartQuestion
     *
     * @param \AppBundle\Entity\IssueChartQuestion $issueChartQuestion
     *
     * @return issueChartQuestion
     */
    public function setIssueChartQuestion(\AppBundle\Entity\IssueChartQuestion $issueChartQuestion = null)
    {
        $this->issueChartQuestion = $issueChartQuestion;

        return $this;
    }

    /**
     * Get issueChartQuestion
     *
     * @return \AppBundle\Entity\IssueChartQuestion
     */
    public function getIssueChartQuestion()
    {
        return $this->issueChartQuestion;
    }
    

    /* To fix: Object of class Proxies\__CG__\AppBundle\Entity\... could not be converted to string"). */
    public function __toString() {
        return $this->name;
    }
}

