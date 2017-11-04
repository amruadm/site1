<?php

namespace AppBundle\Service\Vote;

use AppBundle\Entity\User;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

abstract class VoteListener
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(Request $request, ContainerInterface $container, EntityManagerInterface $entityManager)
    {
        $this->request = $request;
        $this->container = $container;
        $this->entityManager = $entityManager;
    }

    /**
     * @return bool
     */
    public abstract function hasSuccess();

    /**
     * @param User $user
     */
    protected function onSuccess(User $user)
    {
        $user->setCredits(intval($user->getCredits()) + intval($this->container->getParameter('vote_bonus')));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}