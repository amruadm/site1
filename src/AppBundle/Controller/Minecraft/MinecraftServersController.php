<?php

namespace AppBundle\Controller\Minecraft;

use AppBundle\Service\Minecraft\ServersManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MinecraftServersController extends Controller
{
    /**
     * @Rest\Get("api/minecraft/servers")
     */
    public function getServers(ServersManager $serversManager)
    {
        return $serversManager->getServers();
    }
}