<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\User;
use AppBundle\Entity\Post;

class PostController extends Controller
{
	/**
     * @Rest\Get("/api/post")
	 */
	public function getAction()
	{
	    $posts = $this->getDoctrine()->getRepository("AppBundle:Post")->findBy([],['addedDate' => 'DESC'],5);
	    return $posts;
	}

	/**
     * @Rest\Get("api/post/{id}")
	*/
	public function idAction($id)
    {
        $post = $this->getDoctrine()->getRepository("AppBundle:Post")->find($id);
        if(!isset($post)) {
            return new View("Post does not exists", Response::HTTP_NOT_FOUND);
        }
        return $post;
    }

    /**
     *@Rest\Post("api/post", name="post")
    */
    public function postAction(Request $request)
    {
        $currentUser = $this->getUser();

        /*$lastPost = $this->getDoctrine()->getRepository(Post::class)->findBy(
            ['added_by' => $currentUser->getId()],
            ['added_date', 'DESC'],
            1
        );*/

        $body = $request->get("body");
        $title = $request->get("title");

        if($currentUser === FALSE){
            return new View("Access denied", Response::HTTP_FORBIDDEN);
        }

        if(empty($title)
            || empty($body)
        ){
            return new View("Access denied", Response::HTTP_BAD_REQUEST);
        }

        $newPost = new Post();
        $newPost->setAddedBy($currentUser);
        $newPost->setTitle($title);
        $newPost->setBody($body);

        return new View("Added sucifully", Response::HTTP_OK);
    }

    /**
     * @Route("/post", name="post")
    */
    public function editPost(Request $request)
    {
        $user = $this->getUser();
        if($user === FALSE){
            return new View("Access denied", Response::HTTP_FORBIDDEN);
        }

        $error = "";
        if($request->isMethod("POST")){
            $title = $request->get("title");
            $body = $request->get("body");
            $file = $request->files->get("picture");
            if(empty($title) || empty($body)){
                $error = "Не все поля заполненны";
            }
            else{
                $post = new Post();
                $post->setTitle($title);
                $post->setBody($body);
                $post->setAddedBy($user);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($post);

                $manager->flush();
            }
        }

        if(!empty($error)){
            return $this->render("posts/edit.html.twig", ['error' => $error]);
        }
        else{
            return $this->render("posts/edit.html.twig");
        }
    }
}