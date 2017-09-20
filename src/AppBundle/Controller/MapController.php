<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\User;

class MapController extends Controller
{
    /**
     * @Route("/map", name="map")
     */
    public function mapAction()
    {
        return $this->render("default/map.html.twig");
    }

}