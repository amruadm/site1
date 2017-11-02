<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductOrder
 *
 * @ORM\Table(name="product_order", indexes={@ORM\Index(name="order_UserID_FKEY", columns={"UserID"})})
 * @ORM\Entity
 */
class ProductOrder
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ProductID", type="integer", nullable=false)
     */
    private $productid;

    /**
     * @var string
     *
     * @ORM\Column(name="Hash", type="string", length=64, nullable=false)
     */
    private $hash;

    /**
     * @var string
     *
     * @ORM\Column(name="Amount", type="decimal", precision=7, scale=2, nullable=false)
     */
    private $amount;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="UserID", referencedColumnName="id")
     * })
     */
    private $userid;

    /**
     * @var boolean
     * @ORM\Column(name="Amount", type="boolean", nullable=false)
     */
    private $confirmed = false;

    /**
     * @var \DateTime
     * @ORM\Column(name="OrderDate", type="datetime", nullable=false)
     */
    private $orderdate;

    public function __construct()
    {
        $orderdate = new \DateTime();
    }

    /**
     * @return int
     */
    public function getProductid()
    {
        return $this->productid;
    }

    /**
     * @param int $productid
     */
    public function setProductid($productid)
    {
        $this->productid = $productid;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
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
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param User $userid
     */
    public function setUserid(User $userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @param bool $confirmed
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
    }

    /**
     * @return \DateTime
     */
    public function getOrderdate()
    {
        return $this->orderdate;
    }

    /**
     * @param \DateTime $orderdate
     */
    public function setOrderdate(\DateTime $orderdate)
    {
        $this->orderdate = $orderdate;
    }



}

