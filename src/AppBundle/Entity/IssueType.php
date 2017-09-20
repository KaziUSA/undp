<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IssueType
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\IssueTypeRepository")
 */
class IssueType
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
     * @var integer
     *
     * @ORM\Column(name="year", type="integer", length=255)
     */
    private $year;

    /**
     * @var integer
     *
     * @ORM\Column(name="month", type="integer", length=255)
     */
    private $month;


    /**
     * @var integer
     *
     * @ORM\Column(name="chartType", type="integer", nullable=true)
     */
    private $chartType;

    /**
     * @var string
     *
     * @ORM\Column(name="surveyNumber", type="string", length=255, nullable=true)
     */
    private $surveyNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="surveyDetail", type="text", nullable=true)
     */
    private $surveyDetail;

    /**
     * @var string
     *
     * @ORM\Column(name="surveyMen", type="string", length=255, nullable=true)
     */
    private $surveyMen;

    /**
     * @var string
     *
     * @ORM\Column(name="surveyWomen", type="string", length=255, nullable=true)
     */
    private $surveyWomen;

    /**
     * @var integer
     *
     * @ORM\Column(name="isHomepage", type="integer")
     */
    private $isHomepage;

    /**
     * @var integer
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;


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
     * @return IssueType
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
     * Set year
     *
     * @param integer $year
     *
     * @return IssueType
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set month
     *
     * @param integer $month
     *
     * @return IssueType
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer
     */
    public function getMonth()
    {
        return $this->month;
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
     * Set surveyNumber
     *
     * @param string $surveyNumber
     *
     * @return IssueType
     */
    public function setSurveyNumber($surveyNumber)
    {
        $this->surveyNumber = $surveyNumber;

        return $this;
    }

    /**
     * Get surveyNumber
     *
     * @return string
     */
    public function getSurveyNumber()
    {
        return $this->surveyNumber;
    }


    /**
     * Set surveyDetail
     *
     * @param string $surveyDetail
     *
     * @return IssueType
     */
    public function setSurveyDetail($surveyDetail)
    {
        $this->surveyDetail = $surveyDetail;

        return $this;
    }

    /**
     * Get surveyDetail
     *
     * @return string
     */
    public function getSurveyDetail()
    {
        return $this->surveyDetail;
    }


    /**
     * Set surveyMen
     *
     * @param string $surveyMen
     *
     * @return IssueType
     */
    public function setSurveyMen($surveyMen)
    {
        $this->surveyMen = $surveyMen;

        return $this;
    }

    /**
     * Get surveyMen
     *
     * @return string
     */
    public function getSurveyMen()
    {
        return $this->surveyMen;
    }


    /**
     * Set surveyWomen
     *
     * @param string $surveyWomen
     *
     * @return IssueType
     */
    public function setSurveyWomen($surveyWomen)
    {
        $this->surveyWomen = $surveyWomen;

        return $this;
    }

    /**
     * Get surveyWomen
     *
     * @return string
     */
    public function getSurveyWomen()
    {
        return $this->surveyWomen;
    }
    

    /**
     * Set isHomepage
     *
     * @param string $isHomepage
     *
     * @return IssueChartOverview
     */
    public function setIsHomepage($isHomepage)
    {
        $this->isHomepage = $isHomepage;

        return $this;
    }

    /**
     * Get isHomepage
     *
     * @return string
     */
    public function getIsHomepage()
    {
        return $this->isHomepage;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return IssueChartOverview
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /* To fix: Object of class Proxies\__CG__\AppBundle\Entity\... could not be converted to string"). */
    public function __toString() {
        return $this->name;
    }
}

