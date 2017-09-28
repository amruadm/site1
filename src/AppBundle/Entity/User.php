<?php

namespace AppBundle\Entity;


use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="users_login_key", columns={"login"})})
 * @ORM\Entity(repositoryClass="UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=32, nullable=false)
     */
    private $role = 'ROLE_USER';

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=16, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="pass", type="string", length=64, nullable=false)
     */
    private $pass;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reg_date", type="datetime", nullable=false)
     */
    private $regDate = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="string", length=36, nullable=true)
     */
    private $uuid;

    /**
     * @var string
     *
     * @ORM\Column(name="accessToken", type="string", length=32, nullable=true)
     */
    private $accesstoken;

    /**
     * @var string
     *
     * @ORM\Column(name="serverID", type="string", length=41, nullable=true)
     */
    private $serverid;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    function __construct(){
        $this->regDate = new \DateTime();
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     *
     * @return self
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     *
     * @return self
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRegDate()
    {
        return $this->regDate;
    }

    /**
     * @param \DateTime $regDate
     *
     * @return self
     */
    public function setRegDate(\DateTime $regDate)
    {
        $this->regDate = $regDate;

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
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getAccesstoken()
    {
        return $this->accesstoken;
    }

    /**
     * @param string $accesstoken
     */
    public function setAccesstoken($accesstoken)
    {
        $this->accesstoken = $accesstoken;
    }

    /**
     * @return string
     */
    public function getServerid()
    {
        return $this->serverid;
    }

    /**
     * @param string $serverid
     */
    public function setServerid($serverid)
    {
        $this->serverid = $serverid;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->serverid;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getRoles()
    {
        return [$this->role];
    }

    public function getPassword()
    {
        return $this->getPass();
    }

    public function getSalt()
    {
        return '';
    }

    public function getUsername()
    {
        return $this->getLogin();
    }

    public function eraseCredentials()
    {

    }
}
