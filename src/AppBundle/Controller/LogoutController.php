<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LogoutController extends Controller
{
	/**
	 * @Route("/logout", name="logout")
	 */
	public function logoutAction(Request $request)
	{
		return $this->redirectToRoute("homepage");
	}
}