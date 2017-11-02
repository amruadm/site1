<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Minecraft\AvatarTexture;
use AppBundle\Entity\Minecraft\CloakTexture;
use AppBundle\Entity\Minecraft\SkinTexture;
use AppBundle\Service\Minecraft\PermissionManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @Rest\Get("/api/userdata")
     */
	public function getCurrentUserData()
    {
        $user = $this->getUser();

        if(!$user){
            return new View("You are not authenticated", Response::HTTP_FORBIDDEN);
        }

        return $user;
    }

    /**
     * @Route("/user/{login}/pex", name="user/pex")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function setPexGroupAction(User $user, Request $request, PermissionManager $permissionManager)
    {
        $permissionManager->setGroup($user, $request->get('pex_group'));

        return new RedirectResponse($request->headers->get('referer'));
    }

    /**
     * @Route("/user/avatar/set", name="change_avatar")
     * @Security("has_role('ROLE_USER')")
     */
    public function setAvatarAction(Request $request)
    {
        $user = $this->getUser();

        $avatar = new AvatarTexture();
        $file = $request->files->get("avatar");
        $avatar->setImage($file);

        $validator = $this->get('validator');
        $error = $validator->validate($avatar);

        if(count($error) > 0) {
            return new RedirectResponse($request->headers->get('referer'));
        }

        $file->move(
            $this->getParameter("avarats_uploads"),
            $user->getLogin().".png"
        );

        return new RedirectResponse($request->headers->get('referer'));
    }

    /**
     * @Route("/user/skin/set", name="change_skin")
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

        if(count($error) > 0) {
            return new Response("<h1>$error</h1>");
        }

        $file->move(
            $this->getParameter("skins_path"),
            $user->getLogin().".png"
        );

        return new RedirectResponse($request->headers->get('referer'));
    }

    /**
     * @Route("/user/skin/delete", name="delete_skin")
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteSkinAction(Request $request)
    {
        $user = $this->getUser();
        $filename = $this->getParameter("skins_path").$user->getLogin().".png";
        if(file_exists($filename))
        {
            $fs = new Filesystem();
            $fs->remove($filename);
        }

        return new RedirectResponse($request->headers->get('referer'));
    }

    /**
     * @Route("/user/cloak/set", name="change_cloak")
     * @Security("has_role('ROLE_VIP')")
     */
    public function setCloakAction(Request $request)
    {
        $user = $this->getUser();

        $cloak = new CloakTexture();
        $file = $request->files->get("cloak");
        if(empty($file))
            return new RedirectResponse($request->headers->get('referer'));

        $cloak->setImage($file);

        $validator = $this->get('validator');
        $error = $validator->validate($cloak);

        if(!empty($error))
            return new RedirectResponse($request->headers->get('referer'));

        $file->move(
            $this->getParameter("cloak_path"),
            $user->getLogin().".png"
        );

        return new RedirectResponse($request->headers->get('referer'));
    }

    /**
     * @Route("/user/cloak/delete", name="delete_cloak")
     * @Security("has_role('ROLE_VIP')")
     */
    public function deleteCloakAction(Request $request)
    {
        $user = $this->getUser();
        $filename = $this->getParameter("cloak_path").$user->getLogin().".png";
        if(file_exists($filename))
        {
            $fs = new Filesystem();
            $fs->remove($filename);
        }

        return new RedirectResponse($request->headers->get('referer'));
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
     * @Route("/user/{login}/", name="userpage")
     */
    public function userAction(User $user, PermissionManager $permissionManager)
    {
        return $this->render("users/user.html.twig", [
            'user' => $user,
            'pex' => $permissionManager->getGroup($user),
            'pex_groups' => $permissionManager->getAvailableGroups()
        ]);
    }

}