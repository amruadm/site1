<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class InfoController extends Controller
{
    /**
     * @Route("/info/{action}", name="info")
     */
    public function infoAction($action, Request $request)
    {
        $infoConfig = Yaml::parse(file_get_contents($this->get('kernel')->getRootDir().'/config/info_config.yml'));

        if(isset($infoConfig[$action])){

            $filename = $this->get('kernel')->getRootDir().'/Resources/views/info/'.$action.'.html';

            if(!file_exists($filename)){
                file_put_contents($filename, "<h1>Please put content to this page</h1>");
            }

            $contents = file_get_contents($filename);

            $title = isset($infoConfig[$action]['title'])?$infoConfig[$action]['title']:$action;

            if($request->isMethod('post')){

                if(!$this->get("security.authorization_checker")->isGranted("ROLE_ADMIN")){
                    throw $this->createAccessDeniedException();
                }

                $contents = $request->get('page_value');
                file_put_contents($filename, $contents);
            }

            return $this->render("info/info_page_base.html.twig", [
                'action' => $action,
                'title' => $title
            ]);
        }
        else{
            throw $this->createNotFoundException();
        }
    }
}