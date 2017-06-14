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
     * @ORM\ManyToOne(targetEntity="IssueMapName", inversedBy="issuequestion")
     * @ORM\JoinColumn(name="issue_map_name_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $issueMapName;


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

    /* To fix: Object of class Proxies\__CG__\AppBundle\Entity\IssueQuestion could not be converted to string"). */
    public function __toString() {
        return $this->name;
    }
}

