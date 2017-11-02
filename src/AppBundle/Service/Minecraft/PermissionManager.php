<?php

namespace AppBundle\Service\Minecraft;

use AppBundle\Entity\Product;
use AppBundle\Entity\ProductOrder;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class PermissionManager
{
    private $manager;
    private $availableGroups;

    public function __construct(EntityManagerInterface $manager, $groups)
    {
        $this->manager = $manager;
        $this->availableGroups = $groups;
    }

    /**
     * @param User $user
     * @return string
     */
    public function getGroup(User $user)
    {
        $result = "Player";

        $conn = $this->manager->getConnection();

        //Only custom SQL, PEX is strange
        $statement = $conn->prepare(
            "SELECT pexi.parent FROM permissions_inheritance pexi
                      WHERE pexi.type = 1  AND pexi.child in (SELECT p.name FROM permissions p WHERE p.type=1 AND p.value = :login)"
        );
        $statement->bindValue('login', $user->getLogin());
        $statement->execute();

        $results = $statement->fetchAll();

        if(count($results) > 0)
        {
            $result = $results[0]['parent'];
        }

        return $result;
    }

    /**
     * @param User $user
     * @param $group string
     */
    public function setGroup(User $user, $group)
    {
        if(!in_array($group, $this->availableGroups))
            return;

        //Find in child column uuid of user and set Parent to new group (Player, VIP, etc...)

        //Only custom SQL, PEX is strange
        $conn = $this->manager->getConnection();
        $statement = $conn->prepare(
            "UPDATE permissions_inheritance pexi SET pexi.parent = :gr 
                      WHERE pexi.type = 1 AND pexi.child in (SELECT p.name FROM permissions p WHERE p.type=1 AND p.value = :login)"
        );
        $statement->bindValue('gr', $group);
        $statement->bindValue('login', $user->getLogin());
        $statement->execute();

        $roles = [
            'VIP' => 'ROLE_VIP',
            'Premium' => 'ROLE_PREMIUM'
        ];

        if(key_exists($group, $roles))
            $this->setRole($user, $roles[$group]);
    }

    /**
     * Return validity of permission group (null if infinity)
     *
     * @param User $user
     * @return \DateTime
     */
    public function getEndDate(User $user)
    {
        $result = null;

        $results = $this->manager->getRepository(ProductOrder::class)->findBy([
            'userid' => $user,
            'productid' => [1,2]
        ], [
            'datetime' => 'DESC'
        ], 1);

        if(count($results) > 0)
        {
            $result = new \DateTime($results[0]);
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getAvailableGroups()
    {
        return $this->availableGroups;
    }

    /**
     * Return permission group from product (null if product is not a group)
     *
     * @param Product $product
     * @return string
     */
    public function getFromProduct(Product $product)
    {
        //Пока костыльно
        $id = $product->getId();
        $groups = [
            1 => 'VIP',
            2 => 'Premium'
        ];
        if(key_exists($id, $groups))
        {
            return $groups[$id];
        }
        return null;
    }

    /**
     * Return role from product (null if product is not a group)
     *
     * @param Product $product
     * @return string
     */
    public function getRoleFromProduct(Product $product)
    {
        //Пока костыльно
        $id = $product->getId();
        $groups = [
            1 => 'ROLE_VIP',
            2 => 'ROLE_PREMIUM'
        ];
        if(key_exists($id, $groups))
        {
            return $groups[$id];
        }
        return null;
    }

    /**
     * Setting up user role
     *
     * @param User $user
     * @param string $role
     */
    public function setRole(User $user, $role)
    {
        $user->setRole($role);
        $this->manager->persist($user);
        $this->manager->flush();
    }
}