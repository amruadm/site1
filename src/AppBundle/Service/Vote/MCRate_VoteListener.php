<?php

namespace AppBundle\Service\Vote;


use AppBundle\Entity\User;

class MCRate_VoteListener extends VoteListener
{

    /**
     * @return bool
     */
    public function hasSuccess()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['login' => $this->request->get('nick')]);
        $signature = strtoupper($this->request->get('hash'));
        $secret = $this->container->getParameter('mcrate_secret');

        if(empty($user))
        {
            return false;
        }

        if($signature != strtoupper(sha1($user->getLogin().$secret.'mcrate')))
        {
            return false;
        }

        $this->onSuccess($user);
        return true;
    }
}