<?php

namespace AppBundle\Controller;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
	/**
	 * @Route("/login", name="login")
	 */
	public function loginAction(Request $request, AuthenticationUtils $authUtil)
	{
		$error = $authUtil->getLastAuthenticationError();

        $request->getSession()->set('error', $error);

		return $this->redirectToRoute("homepage");
	}
}