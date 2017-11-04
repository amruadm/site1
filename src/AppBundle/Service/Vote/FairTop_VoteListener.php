<?php

namespace AppBundle\Service\Vote;


use AppBundle\Entity\User;

class FairTop_VoteListener extends VoteListener
{

    /**
     * @return bool
     */
    public function hasSuccess()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['login' => $this->request->get('player')]);
        $signature = strtoupper($this->request->get('hash'));
        $secret_close = $this->container->getParameter('fairtop_closekey');

        if(empty($user))
        {
            return false;
        }

        if($signature != strtoupper(md5(sha1($user->getLogin().':'.$secret_close))))
        {
            return false;
        }

        $this->onSuccess($user);
        return true;
    }
}