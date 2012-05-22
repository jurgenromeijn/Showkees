<?php

namespace Mooi\UserBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordValidator extends ConstraintValidator
{

    public function isValid($value, Constraint $constraint)
    {
        
        if(!empty($value) && strleng($value))
        
        if (!in_array($value, $constraint->protocols)) {
            $this->setMessage($constraint->message, array('%protocols%' => $constraint->protocols));

            return false;
        }

        return true;
    }
    
}