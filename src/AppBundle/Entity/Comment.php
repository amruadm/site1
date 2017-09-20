<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;
use AppBundle\Entity\Post;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Comment
 *
 * @ORM\Table(name="comment", indexes={@ORM\Index(name="fki_added_by_fkey", columns={"added_by"}), @ORM\Index(name="fki_post_id_fkey", columns={"post_id"})})
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="added_date", type="datetime", nullable=false)
     */
    private $addedDate = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="comm_text", type="text", length=65535, nullable=true)
     */
    private $commText;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
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

    /**
     * @var \AppBundle\Entity\Post
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * })
     */
    private $post;

    public function __construct()
    {
        $this->addedDate = new \DateTime();
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
     */
    public function setAddedDate($addedDate)
    {
        $this->addedDate = $addedDate;
    }

    /**
     * @return string
     */
    public function getCommText()
    {
        return $this->commText;
    }

    /**
     * @param string $commText
     */
    public function setCommText($commText)
    {
        $this->commText = $commText;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Users
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }

    /**
     * @param \AppBundle\Entity\User $addedBy
     */
    public function setAddedBy(\AppBundle\Entity\User $addedBy)
    {
        $this->addedBy = $addedBy;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param \AppBundle\Entity\Post $post
     */
    public function setPost(\AppBundle\Entity\Post $post)
    {
        $this->post = $post;
    }



}

