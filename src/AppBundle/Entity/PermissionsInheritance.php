<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PermissionsInheritance
 *
 * @ORM\Table(name="permissions_inheritance", uniqueConstraints={@ORM\UniqueConstraint(name="child", columns={"child", "parent", "type", "world"})}, indexes={@ORM\Index(name="child_2", columns={"child", "type"}), @ORM\Index(name="parent", columns={"parent", "type"})})
 * @ORM\Entity
 */
class PermissionsInheritance
{
    /**
     * @var string
     *
     * @ORM\Column(name="child", type="string", length=50, nullable=false)
     */
    private $child;

    /**
     * @var string
     *
     * @ORM\Column(name="parent", type="string", length=50, nullable=false)
     */
    private $parent;

    /**
     * @var boolean
     *
     * @ORM\Column(name="type", type="boolean", nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="world", type="string", length=50, nullable=true)
     */
    private $world;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}

