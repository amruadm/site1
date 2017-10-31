<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        /*return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);*/

        $error = $request->getSession()->get('error');
        $request->getSession()->remove('error');

        return $this->render('default/main.html.twig', ['error' => $error]);
    }

    /**
     * @Route("/launcher", name="launcher")
     */
    public function launcherAction()
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findBy([], ['addedDate' => 'DESC']);

        return $this->render('default/launcher.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Rest\Route("/api/request/ok")
     */
    public function okAction()
    {
        return new Response('OK', Response::HTTP_OK);
    }
}
