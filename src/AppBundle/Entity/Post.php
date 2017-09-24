<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
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
     * @Assert\NotBlank()
     * @ORM\Column(name="body", type="text", length=65535, nullable=true)
     */
    private $body;

    /**
     * @var string
     * @Assert\NotBlank(message="Please, upload the image")
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/png", "image/jpeg"},
     *     mimeTypesMessage = "Please upload a valid PNG"
     * )
     * @ORM\Column(name="image", type="string", length=32, nullable=true)
     */
    private $image;

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
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
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
     * @return User
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }

    /**
     * @param User $addedBy
     */
    public function setAddedBy(User $addedBy)
    {
        $this->addedBy = $addedBy;
    }




}

