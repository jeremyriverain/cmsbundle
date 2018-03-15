<?php

namespace Geekco\CmsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ImageResourceValidator extends ConstraintValidator
{
    public function validate($protocol, Constraint $constraint)
    {
        if ($protocol->getImageFile() === null && $protocol->getImage() === null) {
            return $this->context
                ->buildViolation($constraint->message)
                ->atPath('imageFile')
                ->addViolation()
                ;
        }
    }
}
