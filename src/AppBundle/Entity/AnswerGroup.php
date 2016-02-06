<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AnswerGroup
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AnswerGroupRepository")
 */
class AnswerGroup
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
     * @ORM\OneToMany(targetEntity="Question", mappedBy="answer_group")
     */
    protected $questions;
    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="answer_group")
     */
    protected $answers;
    
    /**
     * @ORM\OneToMany(targetEntity="Answeroption", mappedBy="answer_group")
     */
    protected $answeroptions;
    
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
     * @return AnswerGroup
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
    
    public function __construct()
    {
        
        $this->questions = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->answeroptions = new ArrayCollection();
    }
    
    public function __toString() {
        return $this->name;
    }
    

    /**
     * Add question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return AnswerGroup
     */
    public function addQuestion(\AppBundle\Entity\Question $question)
    {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \AppBundle\Entity\Question $question
     */
    public function removeQuestion(\AppBundle\Entity\Question $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Add answeroption
     *
     * @param \AppBundle\Entity\Answeroption $answeroption
     *
     * @return AnswerGroup
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
     * Add answer
     *
     * @param \AppBundle\Entity\Answer $answer
     *
     * @return AnswerGroup
     */
    public function addAnswer(\AppBundle\Entity\Answer $answer)
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \AppBundle\Entity\Answer $answer
     */
    public function removeAnswer(\AppBundle\Entity\Answer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }
}
