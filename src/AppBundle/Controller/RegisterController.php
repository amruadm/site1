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

class RegisterController extends Controller
{
	/**
	 * @Route("/register", name="register")
	 */
	public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
	{

		$user = new User();

		$form = $this->createFormBuilder($user)
			->add('login', TextType::class, ['label' => 'Логин'])
			->add('pass', PasswordType::class, ['label' => 'Пароль '])
			->add('cpass', PasswordType::class, ['label' => 'Подтверждение', 'mapped' => false])
			->add('save', SubmitType::class, ['label' => 'Зарегаться'])
			->getForm();

		$form->handleRequest($request);

		$error_msg = "";

		if($form->get("cpass")->getData() == $form->get("pass")->getData()){
			if($form->isSubmitted() && $form->isValid()){
				$user = $form->getData();
				$user->setPass($passwordEncoder->encodePassword($user, $user->getPass()));

				try{
					$em = $this->getDoctrine()->getManager();
					$em->persist($user);
					$em->flush();
					return $this->redirectToRoute("homepage");
				}
				catch(Exception $e){
					$error_msg = "Введите другое имя пользователя";
				}
			}
		}
		else{
			$error_msg = "Пароли не совпадают";
		}

		return $this->render('register/register.html.twig', [
			'form' => $form->createView(),
			'error' => $error_msg
		]);
	}
}