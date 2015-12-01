<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="disability", type="smallint")
     */
    private $disability;

    /**
     * @ORM\ManyToOne(targetEntity="Age", inversedBy="surveys")
     * @ORM\JoinColumn(name="age_id", referencedColumnName="id")
     */
    protected $age;

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
}
