<?php

namespace IEEE\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * suggest
 *
 * @ORM\Table(name="suggest")
 * @ORM\Entity(repositoryClass="IEEE\UserBundle\Repository\suggestRepository")
 */
class suggest
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
     *@ORM\ManyToOne(targetEntity="IEEE\UserBundle\Entity\User", inversedBy="suggests") 
     */  
    private $user;

    /**
     *@ORM\OneToMany(targetEntity="IEEE\UserBundle\Entity\comment", mappedBy="suggest")
     */
    private $comments;


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
     * @return suggest
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
     * @return suggest
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
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set user
     *
     * @param \IEEE\UserBundle\Entity\User $user
     *
     * @return suggest
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

    /**
     * Add comment
     *
     * @param \IEEE\UserBundle\Entity\comment $comment
     *
     * @return suggest
     */
    public function addComment(\IEEE\UserBundle\Entity\comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \IEEE\UserBundle\Entity\comment $comment
     */
    public function removeComment(\IEEE\UserBundle\Entity\comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
