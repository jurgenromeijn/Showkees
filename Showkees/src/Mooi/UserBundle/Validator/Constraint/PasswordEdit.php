<?php

namespace Mooi\UserBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class Password extends Constraint
{
    
    public $message = 'This is not a valid password';
    
}
