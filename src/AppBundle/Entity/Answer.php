<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Answer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AnswerRepository")
 */
class Answer
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
     * @ORM\Column(name="weight", type="integer")
     */
    private $weight = 1;
    
    /**
     * @ORM\ManyToOne(targetEntity="AnswerGroup", inversedBy="answers")
     * @ORM\JoinColumn(name="answer_group_id", referencedColumnName="id")
     */
    protected $answer_group;
    
    /**
     * @ORM\OneToMany(targetEntity="Response", mappedBy="answer")
     */
    protected $responses;
    
    /**
     * @ORM\OneToMany(targetEntity="SurveyResponse", mappedBy="answer")
     */
    protected $surveyresponses;
    
    /**
     * @ORM\OneToMany(targetEntity="Answeroption", mappedBy="answer")
     */
    protected $answeroptions;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
        $this->surveyresponses = new ArrayCollection();
        $this->answeroptions = new ArrayCollection();
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
     * @return Answer
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
     * Set weight
     *
     * @param integer $weight
     *
     * @return Answer
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Add response
     *
     * @param \AppBundle\Entity\Response $response
     *
     * @return Answer
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
     * @return Answer
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
     * Add answeroption
     *
     * @param \AppBundle\Entity\Answeroption $answeroption
     *
     * @return Answer
     */
    public function addAnsweroption(\AppBundle\Entity\Answeroption $answeroption)
    {
        $this->answeroptions[] = $answeroption;

        return $this;
    }

    /**
     * Remove answeroption
     *
     * @param \AppBundle\Entity\Answeroption $answeroption
     */
    public function removeAnsweroption(\AppBundle\Entity\Answeroption $answeroption)
    {
        $this->answeroptions->removeElement($answeroption);
    }

    /**
     * Get answeroptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnsweroptions()
    {
        return $this->answeroptions;
    }

    /**
     * Set answerGroup
     *
     * @param \AppBundle\Entity\AnswerGroup $answerGroup
     *
     * @return Answer
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
