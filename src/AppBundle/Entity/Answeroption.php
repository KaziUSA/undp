<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answeroption
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AnsweroptionRepository")
 */
class Answeroption
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
     * @ORM\ManyToOne(targetEntity="AnswerGroup", inversedBy="answeroptions")
     * @ORM\JoinColumn(name="answer_group_id", referencedColumnName="id")
     */
    protected $answer_group;
    
    /**
     * @ORM\ManyToOne(targetEntity="Answer", inversedBy="answeroptions")
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
     * Set answerGroup
     *
     * @param \AppBundle\Entity\AnswerGroup $answerGroup
     *
     * @return Answeroption
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

    /**
     * Set answer
     *
     * @param \AppBundle\Entity\Answer $answer
     *
     * @return Answeroption
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
}
