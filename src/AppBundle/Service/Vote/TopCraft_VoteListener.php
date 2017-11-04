<?php
/**
 * Created by PhpStorm.
 * User: Evgeny
 * Date: 04.11.2017
 * Time: 20:11
 */

namespace AppBundle\Service\Vote;


use AppBundle\Entity\User;

class TopCraft_VoteListener extends VoteListener
{

    /**
     * @return User
     */
    public function hasSuccess()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['login' => $this->request->get('username')]);
        $timestamp = $this->request->get('timestamp');
        $signature = strtoupper($this->request->get('signature'));
        $secret = $this->container->getParameter('topcraft_secret');

        if(empty($user))
        {
            return false;
        }

        if($signature != strtoupper(sha1($user->getLogin().$timestamp.$secret)))
        {
            return false;
        }

        $this->onSuccess($user);
        return true;
    }
}