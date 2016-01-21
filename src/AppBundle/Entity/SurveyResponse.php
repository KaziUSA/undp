<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SurveyResponse
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SurveyResponseRepository")
 */
class SurveyResponse
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
     * @ORM\ManyToOne(targetEntity="Survey", inversedBy="surveyresponses")
     * @ORM\JoinColumn(name="survey_id", referencedColumnName="id")
     */
    protected $survey;
    
    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="surveyresponses")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    protected $question;
    
    /**
     * @ORM\ManyToOne(targetEntity="Answer", inversedBy="surveyresponses")
     * @ORM\JoinColumn(name="answer_id", referencedColumnName="id")
     */
    protected $answer;
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
     * Set survey
     *
     * @param \AppBundle\Entity\Survey $survey
     *
     * @return SurveyResponse
     */
    public function setSurvey(\AppBundle\Entity\Survey $survey = null)
    {
        $this->survey = $survey;

        return $this;
    }

    /**
     * Get survey
     *
     * @return \AppBundle\Entity\Survey
     */
    public function getSurvey()
    {
        return $this->survey;
    }

    /**
     * Set question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return SurveyResponse
     */
    public function setQuestion(\AppBundle\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \AppBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set answer
     *
     * @param \AppBundle\Entity\Answer $answer
     *
     * @return SurveyResponse
     */
    public function setAnswer(\AppBundle\Entity\Answer $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return \AppBundle\Entity\Answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }
    public function __toString() {
        return $this->name;
    }
}
