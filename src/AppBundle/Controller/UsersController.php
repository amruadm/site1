<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\User;

class UsersController extends Controller
{
	/**
     * @Rest\Get("/api/users")
	 */
	public function usersAction()
	{
        $users = $this->getDoctrine()->getRepository("AppBundle:User")->findAll();
        return $users;
		/*$random_num = mt_rand(0, 100);

		return $this->render('register/register.html.twig', [
			'number' => $random_num
		]);*/
	}

    /**
     * @Route("/administration/users", name="admin/users")
     */
	public function usersAdminAction()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render("users/users.html.twig", [
            'users' => $users
        ]);
    }

	/**
     * @Rest\Get("/api/users/{id}")
     */
	public function idAction($id)
    {
        $resultUser = $this->getDoctrine()->getManager("AppBundle:User")->find($id);
        if(!isset($resultUser)){
            return new View("User not found", Response::HTTP_NOT_FOUND);
        }
        return $resultUser;
    }

    /**
     * @Route("/user/{id}", name="userpage")
     */
    public function userAction($id)
    {
        $resultUser = $this->getDoctrine()->getRepository("AppBundle:User")->find($id);

        return $this->render("users/user.html.twig", [
            'user' => $resultUser
        ]);
    }

}