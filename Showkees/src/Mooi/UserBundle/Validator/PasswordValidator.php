<?php

namespace Mooi\UserBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordValidator extends ConstraintValidator
{

    public function isValid($value, Constraint $constraint)
    {
        
        if(!empty($value) && strlen($value) < 8)
        {
            
            $this->setMessage($constraint->message);
            
            return false;
            
        }

        return true;
        
    }
    
}