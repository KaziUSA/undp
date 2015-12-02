<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Response
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ResponseRepository")
 */
class Response
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
     * @ORM\ManyToOne(targetEntity="AnswerGroup", inversedBy="responses")
     * @ORM\JoinColumn(name="answer_group_id", referencedColumnName="id")
     */
    protected $answer_group;
    
    /**
     * @ORM\ManyToOne(targetEntity="Answer", inversedBy="responses")
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
     * Set answer_group
     *
     * @param \AppBundle\Entity\Question $answer_group
     *
     * @return Response
     */
    public function setAnswerGroup(\AppBundle\Entity\AnswerGroup $answer_group = null)
    {
        $this->answer_group = $answer_group;

        return $this;
    }

    /**
     * Get answer_group
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
     * @return Response
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
