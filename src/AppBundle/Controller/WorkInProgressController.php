<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WorkInProgressController extends Controller
{

    /**
     * @Route("/wip", name="work_in_progress")
     */
    public function viewAction()
    {
        return $this->render("wip.html.twig");
    }

}