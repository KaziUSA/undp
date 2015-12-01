<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Age
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AgeRepository")
 */
class Age
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
     * @return Age
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
     * @ORM\OneToMany(targetEntity="Survey", mappedBy="age")
     */
    protected $survey;

    public function __construct()
    {
        $this->surveys = new ArrayCollection();
    }

    /**
     * Add survey
     *
     * @param \AppBundle\Entity\Survey $survey
     *
     * @return Age
     */
    public function addSurvey(\AppBundle\Entity\Survey $survey)
    {
        $this->survey[] = $survey;

        return $this;
    }

    /**
     * Remove survey
     *
     * @param \AppBundle\Entity\Survey $survey
     */
    public function removeSurvey(\AppBundle\Entity\Survey $survey)
    {
        $this->survey->removeElement($survey);
    }

    /**
     * Get survey
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSurvey()
    {
        return $this->survey;
    }
    public function __toString() {
        return $this->name;
    }
}
