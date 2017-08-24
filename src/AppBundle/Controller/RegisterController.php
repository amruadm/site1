<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\User;

class RegisterController extends Controller
{
	/**
	 * @Route("/register", name="register")
	 */
	public function registerAction(Request $request)
	{

		$user = new User();
		$user->setLogin("Enter your login");

		$form = $this->createFormBuilder($user)
			->add('login', TextType::class, ['label' => 'Login'])
			->add('pass', PasswordType::class, ['label' => 'Password '])
			->add('cpass', PasswordType::class, ['label' => 'Confirm', 'mapped' => false])
			->add('save', SubmitType::class, ['label' => 'Done'])
			->getForm();

		$form->handleRequest($request);

		$error_msg = "";

		if($form->get("cpass")->getData() == $form->get("pass")->getData()){
			if($form->isSubmitted() && $form->isValid()){
				$user = $form->getData();

				$em = $this->getDoctrine()->getManager();
				$em->persist($user);
				$em->flush();

				return $this->redirectToRoute("users");
			}
		}
		else{
			$error_msg = "Pass_Error";
		}

		return $this->render('register/register.html.twig', [
			'form' => $form->createView(),
			'error' => $error_msg
		]);
	}
}