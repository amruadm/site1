<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\User;

class UsersController extends Controller
{
	/**
	 * @Route("/users", name="view")
	 */
	public function usersAction(Request $request)
	{

		

		/*$random_num = mt_rand(0, 100);

		return $this->render('register/register.html.twig', [
			'number' => $random_num
		]);*/
	}
}