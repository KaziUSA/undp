<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Question
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\QuestionRepository")
 */
class Question
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
     * @ORM\Column(name="number", type="string", length=10)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\ManyToOne(targetEntity="AnswerGroup", inversedBy="questions")
     * @ORM\JoinColumn(name="answer_group_id", referencedColumnName="id")
     */
    protected $answer_group;

    /**
     * @ORM\OneToMany(targetEntity="Response", mappedBy="question")
     */
    protected $responses;

    /**
     * @ORM\OneToMany(targetEntity="SurveyResponse", mappedBy="question")
     */
    protected $surveyresponses;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
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
     * Set number
     *
     * @param string $number
     *
     * @return Question
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Question
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
     * Add response
     *
     * @param \AppBundle\Entity\Response $response
     *
     * @return Question
     */
    public function addResponse(\AppBundle\Entity\Response $response)
    {
        $this->responses[] = $response;

        return $this;
    }

    /**
     * Remove response
     *
     * @param \AppBundle\Entity\Response $response
     */
    public function removeResponse(\AppBundle\Entity\Response $response)
    {
        $this->responses->removeElement($response);
    }

    /**
     * Get responses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * Add surveyresponse
     *
     * @param \AppBundle\Entity\SurveyResponse $surveyresponse
     *
     * @return Question
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

    /**
     * Set answerGroup
     *
     * @param \AppBundle\Entity\AnswerGroup $answerGroup
     *
     * @return Question
     */
    public function setAnswerGroup(\AppBundle\Entity\AnswerGroup $answerGroup = null)
    {
        $this->answer_group = $answerGroup;

        return $this;
    }

    /**
     * Get answerGroup
     *
     * @return \AppBundle\Entity\AnswerGroup
     */
    public function getAnswerGroup()
    {
        return $this->answer_group;
    }
}
