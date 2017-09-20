<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\User;

/**
 * Post
 *
 * @ORM\Table(name="post", indexes={@ORM\Index(name="fki_a", columns={"added_by"})})
 * @ORM\Entity
 */
class Post
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=128, nullable=false)
     */
    private $title = 'Empty';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="added_date", type="datetime", nullable=false)
     */
    private $addedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", length=65535, nullable=true)
     */
    private $body;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="added_by", referencedColumnName="id")
     * })
     */
    private $addedBy;

    public function __construct()
    {
        $this->addedDate = new \DateTime();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAddedDate()
    {
        return $this->addedDate;
    }

    /**
     * @param \DateTime $addedDate
     *
     * @return self
     */
    public function setAddedDate(\DateTime $addedDate)
    {
        $this->addedDate = $addedDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     *
     * @return self
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \AppBundle\Entity\User
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }

    /**
     * @param \AppBundle\Entity\User $addedBy
     *
     * @return self
     */
    public function setAddedBy(\AppBundle\Entity\User $addedBy)
    {
        $this->addedBy = $addedBy;

        return $this;
    }
}

