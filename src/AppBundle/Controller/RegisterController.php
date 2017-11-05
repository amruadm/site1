<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\User;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;

class RegisterController extends Controller
{
    /**
     * @Rest\Get("/api/check/user")
     */
    public function checkEmail(Request $request)
    {
        $email = $request->get('email');
        $constraint = new Collection([
            'email' => new Email()
        ]);
        $errors = $this->get('validator')->validate($request->request->all(), $constraint);
        if(count($errors) > 0)
        {
            return false;
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);
        if(empty($user))
        {
            return false;
        }
        return true;
    }

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
			->add('login', TextType::class, ['label' => 'Имя пользователя'])
            ->add('email', EmailType::class, ['label' => 'E-Mail'])
			->add('pass', PasswordType::class, ['label' => 'Пароль '])
			->add('cpass', PasswordType::class, ['label' => 'Подтверждение', 'mapped' => false])
            ->add('capcha', CaptchaType::class, ['label' => 'Введите код с картинки', 'mapped' => false, 'invalid_message' => 'Неверный код с картинки'])
			->add('save', SubmitType::class, ['label' => 'Готово', 'attr' => ['class' => 'btn btn-info']])
			->getForm();

		$form->handleRequest($request);

		$error_msg = [];

		try
        {
            if ($form->get("cpass")->getData() == $form->get("pass")->getData())
            {
                if ($form->isSubmitted())
                {
                    if ($form->isValid())
                    {

                        $validator = $this->get('validator');

                        $user = $form->getData();

                        $errors = $validator->validate($user);

                        $user->setPass($passwordEncoder->encodePassword($user, $user->getPass()));

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

                        $mailer->send($message);

                        return $this->render("register/confirm_wait.html.twig", [
                            'user' => $user
                        ]);
                    }
                    else
                    {
                        $errs = $form->getErrors(true);
                        $error_msg = [];
                        foreach($errs as $err)
                        {
                            $error_msg[] = $err->getMessage();
                        }
                    }
                }
            }
            else
            {
                $error_msg[] = 'Пароли не совпадают';
            }
        }
        catch (Exception $e)
        {
            $error_msg = $e->getMessage();
        }

		return $this->render('register/register.html.twig', [
			'form' => $form->createView(),
			'reg_error' => $error_msg
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
        if($user->getRole() != 'ROLE_CREATED')
            return $this->redirectToRoute("homepage");

        $user->setRole('ROLE_USER');
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->render("register/confirm.html.twig");
    }

    /**
     * @Rest\Post("/api/tryconfirm/{login}", name="tryconfirm")
     */
    function tryConfirmAction(User $user, \Swift_Mailer $mailer){
        if($user->getRole() != 'ROLE_CREATED')
            return new View("User is activated", Response::HTTP_FORBIDDEN);

        $message = (new \Swift_Message('Подтверждение'))
            ->setFrom("admin@craft-life.fun")
            ->setTo($user->getEmail())
            ->setBody($this->render("register/confirm_body.html.twig", [
                'hash' => hash('sha1', hash('md5', $user->getLogin())),
                'login' => $user->getLogin()
            ]), 'text/html');

        $mailer->send($message);

        return new View("OK", Response::HTTP_OK);

    }

    /**
     * @Route("/recovery/{login}", name="recovery/pass")
     */
    function changePassAction(User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $hash = strtoupper($request->get('hash'));
        $localHash = strtoupper($this->generateRecoveryHash($user->getLogin(), $user->getPass()));
        if($localHash != $hash)
        {
            return new Response('', Response::HTTP_FORBIDDEN);
        }
        $form = $this->createFormBuilder()
            ->setAction('/recovery/'.$user->getLogin().'?hash='.$hash)
            ->add('newpass', PasswordType::class, ['label' => 'Новый пароль'])
            ->add('newpass_confirm', PasswordType::class, ['label' => 'Подтвердите пароль'])
            ->add('submit', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn btn-info']])
            ->getForm();
        if($form->isSubmitted() && $form->isValid())
        {
            $formData = $form->getData();
            if($formData['newpass'] != $formData['newpass_confirm'])
            {
                return $this->render('register/recovery_pass.html.twig', [
                    'form' => $form->createView(),
                    'error' => 'Пароли не совпадают'
                ]);
            }
            $data = $form->getData();
            $user->setPass($passwordEncoder->encodePassword($data['newpass']));
            $validator = $this->get('validator');
            $errors = $validator->validate($user);
            if(count($errors) > 0)
            {
                return $this->render('register/recovery_pass.html.twig', [
                    'form' => $form->createView(),
                    'error' => 'Некорректно введён пароль'
                ]);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->render('register/recovery_pass.html.twig', [
                'form' => $form->createView(),
                'success' => true
            ]);
        }
        return $this->render('register/recovery_pass.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/recovery", name="recovery")
     */
    function recoveryAction(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('recovery'))
            ->add('email', EmailType::class, ['label' => 'E-Mail'])
            ->add('submit', SubmitType::class, ['label' => 'Продолжить', 'attr' => ['class' => 'btn btn-info']])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $formData = $form->getData();
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $formData['email']]);
            if(empty($user))
            {
                return $this->render('register/recovery.html.twig', [
                    'form' => $form->createView(),
                    'error' => 'Такой E-Mail не зарегистрирован'
                ]);
            }
            $hash = $this->generateRecoveryHash($user->getLogin(), $user->getPass());
            $message = (new \Swift_Message('Восстановление пароля'))
                ->setFrom("admin@craft-life.fun")
                ->setTo($user->getEmail())
                ->setBody($this->render("register/recovery_body.html.twig", [
                    'hash' => $hash,
                    'login' => $user->getLogin()
                ]), 'text/html');
            $mailer->send($message);
            return $this->render('register/recovery.html.twig', [
                'sended' => true
            ]);
        }
        return $this->render('register/recovery.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param $username
     * @param $oldpass
     * @return string
     */
    private function generateRecoveryHash($username, $oldpass)
    {
        return md5(sha1($username.$this->container->getParameter('secret').$oldpass));
    }
}