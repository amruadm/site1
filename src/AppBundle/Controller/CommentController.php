<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\User;
use AppBundle\Entity\Post;
use AppBundle\Entity\Comment;

class CommentController extends Controller
{
    /**
     * @Rest\Get("/api/comments/{id}")
     */
    public function getAction(Post $post)
    {
        $posts = $this->getDoctrine()->getRepository("AppBundle:Comment")->findBy(['post' => $post->getId()],['addedDate' => 'DESC'],20);
        return $posts;
    }

    /**
     * @Rest\Get("/api/comments/count/{id}")
     */
    public function getCountAction($id)
    {
        return $this->getDoctrine()->getManager("AppBundle:Comment")->createQueryBuilder()
            ->select("count(comment.id)")->from("AppBundle:Comment", "comment")->where("comment.postId=:post_id")->setParameter("post_id", $id)
            ->getQuery()->getSingleScalarResult();
    }

    /**
     * @Rest\Post("/api/comment/{id}")
     * @Security("has_role('ROLE_USER')")
     */
    function postAction(Post $post, Request $request)
    {
        $user = $this->getUser();

        $comment = new Comment();

        $comment->setAddedBy($user);
        $comment->setPost($post);
        $comment->setCommText($request->get("comm_text"));

        $validator = $this->get('validator');
        $errors = $validator->validate($comment);

        if(count($errors) > 0)
        {
            return new View($errors, Response::HTTP_BAD_REQUEST);
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($comment);
        $manager->flush();

        return $comment;
    }

    /**
     * @Rest\Delete("/api/comment/{id}")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    function deleteAction(Comment $comment)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($comment);
        $manager->flush();

        return new View("Deleted", Response::HTTP_OK);
    }
}