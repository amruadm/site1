<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\User;

class AboutController extends Controller
{
	/**
	 * @Route("/about", name="about")
	 */
	public function aboutAction(Request $request)
	{
        $user = $this->getUser();
        $msg = "anonimus";
        if(isset($user)){
            $msg = $user->getUsername();
        }

		return $this->render('about/about.html.twig', [
			'uname' => $msg
		]);
	}
}