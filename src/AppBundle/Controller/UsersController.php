<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Minecraft\CloakTexture;
use AppBundle\Entity\Minecraft\SkinTexture;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\User;

class UsersController extends Controller
{
	/**
     * @Rest\Get("/api/users")
     * @Security("has_role('ROLE_ADMIN')")
	 */
	public function usersAction()
	{
        $users = $this->getDoctrine()->getRepository("AppBundle:User")->findAll();
        return $users;
	}

    /**
     * @Rest\Post("/api/skin")
     * @Security("has_role('ROLE_USER')")
     */
    public function setSkinAction(Request $request)
    {
        $user = $this->getUser();

        $skin = new SkinTexture();
        $file = $request->files->get("skin");
        $skin->setImage($file);

        $validator = $this->get('validator');
        $error = $validator->validate($skin);

        if(!empty($error))
            return new View($error, Response::HTTP_BAD_REQUEST);

        $file->move(
            $this->getParameter("skins_path"),
            $user->getLogin().".png"
        );

        return new View("OK", Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/api/skin")
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteSkinAction(Request $request)
    {
        $user = $this->getUser();
        $filename = $this->getParameter("skins_path").$user->getLogin().".png";
        $fs = new Filesystem();
        $fs->remove($filename);
    }

    /**
     * @Rest\Post("/api/cloak")
     * @Security("has_role('ROLE_VIP')")
     */
    public function setCloakAction(Request $request)
    {
        $user = $this->getUser();

        $cloak = new CloakTexture();
        $file = $request->files->get("cloak");
        $cloak->setImage($file);

        $validator = $this->get('validator');
        $error = $validator->validate($cloak);

        if(!empty($error))
            return new View($error, Response::HTTP_BAD_REQUEST);

        $file->move(
            $this->getParameter("cloak_path"),
            $user->getLogin().".png"
        );

        return new View("OK", Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/api/cloak")
     * @Security("has_role('ROLE_VIP')")
     */
    public function deleteCloakAction(Request $request)
    {
        $user = $this->getUser();
        $filename = $this->getParameter("cloak_path").$user->getLogin().".png";
        $fs = new Filesystem();
        $fs->remove($filename);
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
	public function idAction(User $user)
    {
        return $user;
    }

    /**
     * @Route("/user/{login}", name="userpage")
     */
    public function userAction(User $user)
    {
        $skin_path = $this->getParameter("skins_path").$user->getLogin().".png";
        $skin_url = "/img/uploads/defaultSkin.png";
        if(file_exists($skin_path))
        {
            $skin_url = "/img/uploads/skins/".$user->getLogin().".png";
        }

        return $this->render("users/user.html.twig", [
            'user' => $user,
            'skin' => $skin_url
        ]);
    }

}