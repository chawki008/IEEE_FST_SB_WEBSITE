<?php

namespace IEEE\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="IEEE\UserBundle\Repository\commentRepository")
 */
class comment
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
     * @var string
     *
     * @ORM\Column(name="Date", type="date")
     */
    private $date;

    /**
     *@ORM\ManyToOne(targetEntity="IEEE\UserBundle\Entity\suggest" , inversedBy="comments")
     */
    private $suggest;

    /**
     *@ORM\ManyToOne(targetEntity="IEEE\UserBundle\Entity\User", inversedBy="comments") 
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
     * @return comment
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
     * @param string $date
     *
     * @return comment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set suggest
     *
     * @param \IEEE\UserBundle\Entity\suggest $suggest
     *
     * @return comment
     */
    public function setSuggest(\IEEE\UserBundle\Entity\suggest $suggest = null)
    {
        $this->suggest = $suggest;

        return $this;
    }

    /**
     * Get suggest
     *
     * @return \IEEE\UserBundle\Entity\suggest
     */
    public function getSuggest()
    {
        return $this->suggest;
    }

    /**
     * Set user
     *
     * @param \IEEE\UserBundle\Entity\User $user
     *
     * @return comment
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
