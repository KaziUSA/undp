<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Survey
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SurveyRepository")
 */
class Survey
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="term", type="integer")
     */
    private $term;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="ward", type="integer")
     */
    private $ward;

    /**
     * @var integer
     *
     * @ORM\Column(name="disability", type="smallint")
     */
    private $disability;

    /**
     * @ORM\ManyToOne(targetEntity="Age", inversedBy="surveys")
     * @ORM\JoinColumn(name="age_id", referencedColumnName="id")
     */
    protected $age;
    
    /**
     * @ORM\ManyToOne(targetEntity="District", inversedBy="surveys")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id")
     */
    protected $district;
    
    /**
     * @ORM\ManyToOne(targetEntity="Ethnicity", inversedBy="surveys")
     * @ORM\JoinColumn(name="ethnicity_id", referencedColumnName="id")
     */
    protected $ethnicity;
    
    /**
     * @ORM\ManyToOne(targetEntity="Gender", inversedBy="surveys")
     * @ORM\JoinColumn(name="gender_id", referencedColumnName="id")
     */
    protected $gender;
    
    /**
     * @ORM\ManyToOne(targetEntity="Interviewer", inversedBy="surveys")
     * @ORM\JoinColumn(name="interviewer_id", referencedColumnName="id")
     */
    protected $interviewer;
    
    /**
     * @ORM\ManyToOne(targetEntity="Occupation", inversedBy="surveys")
     * @ORM\JoinColumn(name="occupation_id", referencedColumnName="id")
     */
    protected $occupation;
    
    /**
     * @ORM\ManyToOne(targetEntity="Vdc", inversedBy="surveys")
     * @ORM\JoinColumn(name="vdc_id", referencedColumnName="id")
     */
    protected $vdc;
    
    /**
     * @ORM\OneToMany(targetEntity="SurveyResponse", mappedBy="survey")
     */
    protected $surveyresponses;
    
    public function __construct()
    {
        $this->surveyresponses = new ArrayCollection();
    }
    
    public function __toString() {
        return $this->name;
    }
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Survey
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set term
     *
     * @param integer $term
     *
     * @return Survey
     */
    public function setTerm($term)
    {
        $this->term = $term;

        return $this;
    }

    /**
     * Get term
     *
     * @return integer
     */
    public function getTerm()
    {
        return $this->term;
    }
    
    /**
     * Set ward
     *
     * @param integer $ward
     *
     * @return Survey
     */
    public function setWard($ward)
    {
        $this->ward = $ward;

        return $this;
    }

    /**
     * Get ward
     *
     * @return integer
     */
    public function getWard()
    {
        return $this->ward;
    }

    /**
     * Set disability
     *
     * @param integer $disability
     *
     * @return Survey
     */
    public function setDisability($disability)
    {
        $this->disability = $disability;

        return $this;
    }

    /**
     * Get disability
     *
     * @return integer
     */
    public function getDisability()
    {
        return $this->disability;
    }

    /**
     * Set age
     *
     * @param \AppBundle\Entity\Age $age
     *
     * @return Survey
     */
    public function setAge(\AppBundle\Entity\Age $age = null)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return \AppBundle\Entity\Age
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set district
     *
     * @param \AppBundle\Entity\District $district
     *
     * @return Survey
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

    /**
     * Set ethnicity
     *
     * @param \AppBundle\Entity\Ethnicity $ethnicity
     *
     * @return Survey
     */
    public function setEthnicity(\AppBundle\Entity\Ethnicity $ethnicity = null)
    {
        $this->ethnicity = $ethnicity;

        return $this;
    }

    /**
     * Get ethnicity
     *
     * @return \AppBundle\Entity\Ethnicity
     */
    public function getEthnicity()
    {
        return $this->ethnicity;
    }

    /**
     * Set gender
     *
     * @param \AppBundle\Entity\Gender $gender
     *
     * @return Survey
     */
    public function setGender(\AppBundle\Entity\Gender $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return \AppBundle\Entity\Gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set interviewer
     *
     * @param \AppBundle\Entity\Interviewer $interviewer
     *
     * @return Survey
     */
    public function setInterviewer(\AppBundle\Entity\Interviewer $interviewer = null)
    {
        $this->interviewer = $interviewer;

        return $this;
    }

    /**
     * Get interviewer
     *
     * @return \AppBundle\Entity\Interviewer
     */
    public function getInterviewer()
    {
        return $this->interviewer;
    }

    /**
     * Set occupation
     *
     * @param \AppBundle\Entity\Occupation $occupation
     *
     * @return Survey
     */
    public function setOccupation(\AppBundle\Entity\Occupation $occupation = null)
    {
        $this->occupation = $occupation;

        return $this;
    }

    /**
     * Get occupation
     *
     * @return \AppBundle\Entity\Occupation
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * Set vdc
     *
     * @param \AppBundle\Entity\Vdc $vdc
     *
     * @return Survey
     */
    public function setVdc(\AppBundle\Entity\Vdc $vdc = null)
    {
        $this->vdc = $vdc;

        return $this;
    }

    /**
     * Get vdc
     *
     * @return \AppBundle\Entity\Vdc
     */
    public function getVdc()
    {
        return $this->vdc;
    }

    /**
     * Add surveyresponse
     *
     * @param \AppBundle\Entity\SurveyResponse $surveyresponse
     *
     * @return Survey
     */
    public function addSurveyresponse(\AppBundle\Entity\SurveyResponse $surveyresponse)
    {
        $this->surveyresponses[] = $surveyresponse;

        return $this;
    }

    /**
     * Remove surveyresponse
     *
     * @param \AppBundle\Entity\SurveyResponse $surveyresponse
     */
    public function removeSurveyresponse(\AppBundle\Entity\SurveyResponse $surveyresponse)
    {
        $this->surveyresponses->removeElement($surveyresponse);
    }

    /**
     * Get surveyresponses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSurveyresponses()
    {
        return $this->surveyresponses;
    }
}
