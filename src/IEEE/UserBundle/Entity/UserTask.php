<?php

namespace IEEE\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserTask
 *
 * @ORM\Table(name="user_task")
 * @ORM\Entity(repositoryClass="IEEE\UserBundle\Repository\UserTaskRepository")
 */
class UserTask
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
     *@ORM\ManyToOne(targetEntity="IEEE\UserBundle\Entity\task" , inversedBy="TaskUsers")
     */
    private $task;

    /**
     *@ORM\ManyToOne(targetEntity="IEEE\UserBundle\Entity\User" , inversedBy="UserTasks")
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
     * Set task
     *
     * @param \IEEE\UserBundle\Entity\task $task
     *
     * @return UserTask
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
     * @return UserTask
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
