<?php

namespace AppBundle\Controller\Minecraft;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MinecraftServerStatus\MinecraftServerStatus;

class MinecraftServersController extends Controller
{
    /**
     * @Rest\Get("api/minecraft/servers")
     */
    public function getServers()
    {
        $result = MinecraftServerStatus::query();
        if($result === FALSE){
            return new View("Error", Response::HTTP_FORBIDDEN);
        }
        return $result;
    }
}