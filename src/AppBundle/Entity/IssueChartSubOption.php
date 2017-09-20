<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IssueChartSubOption
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class IssueChartSubOption
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
     * @ORM\ManyToOne(targetEntity="IssueChartOption", inversedBy="issuechartsuboption")
     * @ORM\JoinColumn(name="issue_chart_option_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $issueChartOption;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

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
     * Set name
     *
     * @param string $name
     *
     * @return IssueChartSubOption
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
     * @return IssueChartSubOption
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
     * Set issueChartOption
     *
     * @param \AppBundle\Entity\IssueChartOption $issueChartOption
     *
     * @return issueChartOption
     */
    public function setIssueChartOption(\AppBundle\Entity\IssueChartOption $issueChartOption = null)
    {
        $this->issueChartOption = $issueChartOption;

        return $this;
    }

    /**
     * Get issueChartOption
     *
     * @return \AppBundle\Entity\IssueChartOption
     */
    public function getIssueChartOption()
    {
        return $this->issueChartOption;
    }
}

