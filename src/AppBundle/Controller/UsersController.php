<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\User;

class UsersController extends Controller
{
	/**
     * @Rest\Get("/users")
	 */
	public function usersAction()
	{

		/*$random_num = mt_rand(0, 100);

		return $this->render('register/register.html.twig', [
			'number' => $random_num
		]);*/
	}

	/**
     * @Rest\Get("/users/{id}")
     */
	public function idAction($id)
    {
        $resultUser = $this->getDoctrine()->getManager("AppBundle:User")->find($id);
        if(!isset($resultUser)){
            return new View("User not found", Response::HTTP_NOT_FOUND);
        }
        return $resultUser;
    }

}