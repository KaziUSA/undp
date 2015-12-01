<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interviewer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\InterviewerRepository")
 */
class Interviewer
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
     * @var string
     *
     * @ORM\Column(name="agency", type="string", length=255)
     */
    private $agency;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone = null;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email = null;

    /**
     * @ORM\OneToMany(targetEntity="Survey", mappedBy="interviewer")
     */
    protected $survey;

    public function __construct()
    {
        $this->surveys = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Interviewer
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
     * Set agency
     *
     * @param string $agency
     *
     * @return Interviewer
     */
    public function setAgency($agency)
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * Get agency
     *
     * @return string
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Interviewer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Interviewer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add survey
     *
     * @param \AppBundle\Entity\Survey $survey
     *
     * @return Interviewer
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
}
