<?php

namespace IEEE\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * feedback
 *
 * @ORM\Table(name="feedback")
 * @ORM\Entity(repositoryClass="IEEE\UserBundle\Repository\feedbackRepository")
 */
class feedback
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     *@ORM\ManyToOne(targetEntity="IEEE\UserBundle\Entity\task", inversedBy="updates")
     */   
    private $task;
    /**
     *@ORM\ManyToOne(targetEntity="IEEE\UserBundle\Entity\User", inversedBy="updates") 
     */  
    private $user;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return feedback
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return feedback
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
     * Set task
     *
     * @param \IEEE\UserBundle\Entity\task $task
     *
     * @return feedback
     */
    public function setTask(\IEEE\UserBundle\Entity\task $task = null)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return \IEEE\UserBundle\Entity\task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set user
     *
     * @param \IEEE\UserBundle\Entity\User $user
     *
     * @return feedback
     */
    public function setUser(\IEEE\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \IEEE\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
