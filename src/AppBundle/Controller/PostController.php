<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
	 * @Route("/post/{id}", name="post")
	 */
	public function postAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
	{
		return $this->render('posts/post.html.twig', [

		]);
	}
}