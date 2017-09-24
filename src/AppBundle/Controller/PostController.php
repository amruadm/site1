<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\User;
use AppBundle\Entity\Post;

class PostController extends Controller
{
	/**
     * @Rest\Get("/api/post/{offset}")
	 */
	public function getAction($offset)
	{
	    $posts = $this->getDoctrine()->getRepository("AppBundle:Post")->findBy([],['addedDate' => 'DESC'],8, $offset);
	    return $posts;
	}

	/**
     * @Rest\Get("api/post/get/{id}")
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
     *@Rest\Post("api/post")
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
     * @Route("/post/{id}", name="view_post")
     */
    public function viewPost($id)
    {
        return $this->render("");
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

        $post = new Post();
        $validator = $this->get('validator');

        $form = $this->createFormBuilder($post)
            ->setAction($this->generateUrl('post'))
            ->add('title', TextType::class, ['label' => 'Заголовок'])
            ->add('body', TextareaType::class, ['label' => 'Текст'])
            ->add('image', FileType::class, ['label' => 'Пикча'])
            ->add('submit', SubmitType::class, ['label' => 'Окай'])->getForm();

        $form->handleRequest($request);

        $errors = '';

        if($form->isSubmitted() && $form->isValid()){

            $errors = $validator->validate($post);

            $file = $post->getImage();

            $dt = new \DateTime();

            $filename = 'picture'.$dt->format('YmdHis').'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('image_uploads'),
                $filename
            );

            $post->setImage($filename);
            $post->setAddedBy($user);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);

            $manager->flush();

            $this->redirectToRoute('homepage');
        }

        return $this->render("posts/edit.html.twig", [
            'form' => $form->createView(),
            'error' => $errors
        ]);
    }
}