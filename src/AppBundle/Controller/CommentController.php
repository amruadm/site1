<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\User;
use AppBundle\Entity\Post;
use AppBundle\Entity\Comment;

class CommentController extends Controller
{
    /**
     * @Rest\Get("/api/comments/{id}")
     */
    public function getAction($id)
    {
        $posts = $this->getDoctrine()->getRepository("AppBundle:Comment")->findBy(['post' => $id],['addedDate' => 'DESC'],20);
        return $posts;
    }

    /**
     * @Rest\Post("/api/comment")
     * @Security("has_role('ROLE_USER')")
     */
    function postAction(Request $request)
    {
        $user = $this->getUser();

        $id = $request->get("post_id");
        $targetPost = $this->getDoctrine()->getRepository("AppBundle:Post")->find($id);
        if(!isset($targetPost)){
            return new View("Post doesnt exists",Response::HTTP_BAD_REQUEST);
        }

        if(empty($request->get("comm_text"))){
            return new View("Comment text is empty",Response::HTTP_BAD_REQUEST);
        }

        $comment = new Comment();

        $comment->setAddedBy($user);
        $comment->setPost($targetPost);
        $comment->setCommText($request->get("comm_text"));

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($comment);
        $manager->flush();

        return $comment;
    }

    /**
     * @Rest\Delete("/api/comment/{id}")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    function deleteAction(\AppBundle\Entity\Comment $comment)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($comment);
        $manager->flush();

        return new View("Deleted");
    }
}