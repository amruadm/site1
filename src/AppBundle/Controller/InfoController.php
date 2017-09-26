<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class InfoController extends Controller
{
    /**
     * @Route("/info/commands", name="info/commands")
     */
    public function commandsAction(Request $request)
    {
        return $this->render("info/commands.html.twig");
    }

    /**
     * @Route("/info/faq", name="info/faq")
     */
    public function faqAction(Request $request)
    {
        return $this->render("info/faq.html.twig");
    }

    /**
     * @Route("/info/admins", name="info/admins")
     */
    public function adminsAction(Request $request)
    {
        return $this->render("info/admins.html.twig");
    }

    /**
     * @Route("/info/about", name="info/about")
     */
    public function aboutAction(Request $request)
    {
        return $this->render("info/about.html.twig");
    }

    /**
     * @Route("/info/banned", name="info/banned")
     */
    public function bannedAction(Request $request)
    {
        return $this->render("info/banned.html.twig");
    }

    /**
     * @Route("/info/rules", name="info/rules")
     */
    public function rulesAction(Request $request)
    {
        return $this->render("info/rules.html.twig");
    }
}