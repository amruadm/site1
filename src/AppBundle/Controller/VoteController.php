<?php

namespace AppBundle\Controller;

use AppBundle\Service\Vote\VoteListenerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoteController extends Controller
{
    /**
     * @Route("/vote/{service}", name="vote")
     */
    public function voteAction($service, Request $request, VoteListenerBuilder $voteBuilder)
    {
        $vote = $voteBuilder->getVoteListener($service);

        if(!empty($vote))
        {
            if($vote->hasSuccess())
            {
                return new Response('OK', Response::HTTP_OK);
            }
        }
        return new Response('BAD', Response::HTTP_BAD_REQUEST);
    }
}