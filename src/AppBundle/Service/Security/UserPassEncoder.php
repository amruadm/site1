<?php

namespace AppBundle\Service\Security;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class UserPassEncoder implements PasswordEncoderInterface
{

    /**
     * Encodes the raw password.
     *
     * @param string $raw The password to encode
     * @param string $salt The salt
     *
     * @return string The encoded password
     */
    public function encodePassword($raw, $salt)
    {
        return hash('sha1', $salt . $raw);
    }

    /**
     * Checks a raw password against an encoded password.
     *
     * @param string $encoded An encoded password
     * @param string $raw A raw password
     * @param string $salt The salt
     *
     * @return bool true if the password is valid, false otherwise
     */
    public function isPasswordValid($encoded, $raw, $salt)
    {
        return $encoded == $this->encodePassword($raw, $salt);
    }
}