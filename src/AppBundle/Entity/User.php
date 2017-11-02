<?php

namespace AppBundle\Entity;


use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * User
 *
 * @ORM\Table(name="user",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="users_login_key", columns={"login"}),
 *          @ORM\UniqueConstraint(name="users_email_key", columns={"email"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="UserRepository")
 * @UniqueEntity(
 *     fields={"login"},
 *     errorPath="homepage",
 *     message="Такой пользователь уже существует"
 * )
 * @UniqueEntity(
 *     fields={"email"},
 *     errorPath="homepage",
 *     message="Такой E-Mail уже используется"
 * )
 * @Serializer\AccessType("public_method")
 */
class User implements UserInterface
{

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=32, nullable=false)
     */
    private $role = 'ROLE_CREATED';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=24, nullable=false, unique=true)
     * @Assert\Email(
     *     message = "Некорректный E-Mail: '{{ value }}'",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=16, nullable=false, unique=true)
     * @Assert\Regex(
     *      pattern="/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/",
     *      message="Имя пользователя содержит некорректные символы"
     * )
     * @Assert\Length(
     *      min = 4,
     *      max = 16,
     *      minMessage = "Логин должен быть не короче {{ limit }} символов",
     *      maxMessage = "Логин должен быть не длиннее {{ limit }} символов"
     * )
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="pass", type="string", length=64, nullable=false)
     * @Assert\Length(
     *      min = 8,
     *      max = 16,
     *      minMessage = "Пароль должен быть не короче {{ limit }} символов",
     *      maxMessage = "Пароль должен быть не длиннее {{ limit }} символов"
     * )
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
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
        return $this->role;
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
        if($this->role == 'ROLE_ADMIN')
            return ['ROLE_USER', 'ROLE_VIP', 'ROLE_PREMIUM', 'ROLE_ADMIN'];
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

    /**
     * @return string
     */
    public function getSkin()
    {
        $skinsDir = __DIR__.'/../../../web/img/uploads/skins/';
        if(!file_exists($skinsDir.$this->login.'.png'))
        {
            return '/img/uploads/defaultSkin.png';
        }
        return '/img/uploads/skins/'.$this->login.'.png';
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        $avatarDir = __DIR__.'/../../../web/img/uploads/ava/';
        if(!file_exists($avatarDir.$this->login.'.png'))
        {
            return '/img/uploads/defaultAvatar.png';
        }
        return '/img/uploads/ava/'.$this->login.'.png';
    }
}
