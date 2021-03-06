<?php

namespace IEEE\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="IEEE\UserBundle\Repository\taskRepository")
 */
class task
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
     * @ORM\Column(name="Date", type="date")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadline", type="date")
     */
    private $deadline;

    /**
     * @var bool
     *
     * @ORM\Column(name="done", type="boolean")
     */
    private $done;

    /**   
     *@ORM\OneToMany(targetEntity="IEEE\UserBundle\Entity\UserTask",mappedBy="task")
     */
    private $TaskUsers;
    
    /**
     *@ORM\OneToMany(targetEntity="IEEE\UserBundle\Entity\feedback" , mappedBy="task")
     */
    private $updates;
    
    /**
     *@ORM\ManyToOne(targetEntity="IEEE\UserBundle\Entity\User", inversedBy="tasksResponOn");
     */
    private $responsible;


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
     * @return task
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
     * @return task
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
     * Set deadline
     *
     * @param \DateTime $deadline
     *
     * @return task
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get deadline
     *
     * @return \DateTime
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set done
     *
     * @param boolean $done
     *
     * @return task
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done
     *
     * @return bool
     */
    public function getDone()
    {
        return $this->done;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->TaskUsers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->updates = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add taskUser
     *
     * @param \IEEE\UserBundle\Entity\UserTask $taskUser
     *
     * @return task
     */
    public function addTaskUser(\IEEE\UserBundle\Entity\UserTask $taskUser)
    {
        $this->TaskUsers[] = $taskUser;

        return $this;
    }

    /**
     * Remove taskUser
     *
     * @param \IEEE\UserBundle\Entity\UserTask $taskUser
     */
    public function removeTaskUser(\IEEE\UserBundle\Entity\UserTask $taskUser)
    {
        $this->TaskUsers->removeElement($taskUser);
    }

    /**
     * Get taskUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTaskUsers()
    {
        return $this->TaskUsers;
    }

    /**
     * Add update
     *
     * @param \IEEE\UserBundle\Entity\feedbacks $update
     *
     * @return task
     */
    public function addUpdate(\IEEE\UserBundle\Entity\feedback $update)
    {
        $this->updates[] = $update;

        return $this;
    }

    /**
     * Remove update
     *
     * @param \IEEE\UserBundle\Entity\feedbacks $update
     */
    public function removeUpdate(\IEEE\UserBundle\Entity\feedback $update)
    {
        $this->updates->removeElement($update);
    }

    /**
     * Get updates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUpdates()
    {
        return $this->updates;
    }

    /**
     * Set responsible
     *
     * @param \IEEE\UserBundle\Entity\User $responsible
     *
     * @return task
     */
    public function setResponsible(\IEEE\UserBundle\Entity\User $responsible = null)
    {
        $this->responsible = $responsible;

        return $this;
    }

    /**
     * Get responsible
     *
     * @return \IEEE\UserBundle\Entity\User
     */
    public function getResponsible()
    {
        return $this->responsible;
    }
}
