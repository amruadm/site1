<?php

namespace AppBundle\Controller;

use AppBundle\Service\Minecraft\LoginUUIDEncoder;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
	public function registerAction(Request $request,
                                   UserPasswordEncoderInterface $passwordEncoder,
                                   \Swift_Mailer $mailer)
	{

		$user = new User();

		$form = $this->createFormBuilder($user)
            ->setAction($this->generateUrl('register'))
			->add('login', TextType::class, ['label' => 'Логин'])
            ->add('email', EmailType::class, ['label' => 'E-Mail'])
			->add('pass', PasswordType::class, ['label' => 'Пароль '])
			->add('cpass', PasswordType::class, ['label' => 'Подтверждение', 'mapped' => false])
            ->add('capcha', CaptchaType::class, ['label' => 'Капча', 'mapped' => false])
			->add('save', SubmitType::class, ['label' => 'Зарегаться'])
			->getForm();

		$form->handleRequest($request);

		$error_msg = "";

		if($form->get("cpass")->getData() == $form->get("pass")->getData()){
			if($form->isSubmitted() && $form->isValid()){

                $validator = $this->get('validator');

				$user = $form->getData();

                $errors = $validator->validate($user);

				$user->setPass($passwordEncoder->encodePassword($user, $user->getPass()));

				try{
					$em = $this->getDoctrine()->getManager();
					$em->persist($user);
					$em->flush();

					$message = (new \Swift_Message('Подтверждение'))
                        ->setFrom("admin@craft-life.fun")
                        ->setTo($user->getEmail())
                        ->setBody($this->render("register/confirm_body.html.twig", [
                            'hash' => hash('sha1', hash('md5', $user->getLogin())),
                            'login' => $user->getLogin()
                        ]), 'text/html');

					if($mailer->send($message) == FALSE){
					    return $this->render("woops.html.twig", ['reason' => 'свфитмаилер вернул ноль']);
                    }

					return $this->render("register/confirm_wait.html.twig");
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

	/**
     * @Route("/confirm/{hash}")
     */
	function confirmAction($hash)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);

        $query = $repo->createQueryBuilder('u')->where('SHA1(MD5(u.login)) = :hash')
            ->setParameter('hash', $hash)->getQuery();
        $user = $query->setMaxResults(1)->getOneOrNullResult();

        if(!$user)
            return $this->redirectToRoute("homepage");
        if($user->getActive())
            return $this->redirectToRoute("homepage");

        $user->setActive(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->render("register/confirm.html.twig");
    }
/*
    /**
     * @Rest/Post("/api/tryconfirm/{id}")
     */
    /*function tryconfirmAction(User $user)
    {
        if($user->getActive())
            return new View("User is activated", Response::HTTP_FORBIDDEN);


    }*/
}