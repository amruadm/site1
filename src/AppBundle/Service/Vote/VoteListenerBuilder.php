<?php

namespace AppBundle\Service\Vote;


use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class VoteListenerBuilder
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(RequestStack $requestStack, ContainerInterface $container, EntityManagerInterface $manager)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->container = $container;
        $this->manager = $manager;
    }

    /**
     * @param string $vote
     * @return VoteListener
     */
    public function getVoteListener($vote)
    {
        switch ($vote)
        {
            case 'MCRate': return new MCRate_VoteListener($this->request, $this->container, $this->manager);
            case 'TopCraft': return new TopCraft_VoteListener($this->request, $this->container, $this->manager);
            case 'FairTop': return new FairTop_VoteListener($this->request, $this->container, $this->manager);
        }
        return null;
    }
}