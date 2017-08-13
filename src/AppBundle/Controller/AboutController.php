<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AboutController extends Controller
{
	/**
	 * @Route("/about", name="about")
	 */
	public function aboutAction(Request $request)
	{

		$random_num = mt_rand(0, 100);

		return $this->render('about/about.html.twig', [
			'number' => $random_num
		]);
	}
}