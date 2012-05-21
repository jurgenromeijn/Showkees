<?php

namespace Mooi\UserBundle\Model;

use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserFactory
{
    
    protected $em;
    protected $encoder_factory;
    
    public function __construct(EncoderFactoryInterface $encoder_factory)
    {
        $this->encoder_factory = $encoder_factory;
    }
    
    /**
     * @param UserInterface $user user to be encoded
     * @param string $password password to encode for user (or null to use getPassword() method from user)
     * @return string encoded password
     */
    public function encode(UserInterface $user, $password = null)
    {
        $encoder = $this->encoder_factory->getEncoder($user);
        $toEncode = null === $password ? $user->getPassword() : $password;
        $encoded = $encoder->encodePassword($toEncode, $user->getSalt());
                
        return $encoded;
    }

}