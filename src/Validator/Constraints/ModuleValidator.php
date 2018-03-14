<?php
namespace Geekco\CmsBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ModuleValidator extends ConstraintValidator

{
    public function validate($protocol, Constraint $constraint)
    {

        if($protocol->getIsBase() === true && $protocol->getPage() !== null)
        {
            $this->context
                ->buildViolation($constraint->notPaginable)
                ->atPath('name')
                ->addViolation();
        }

        if ($protocol->getParent() === null && $protocol->getLabel() === null)
        {

            $this->context
                ->buildViolation($constraint->labelNotFilled)
                ->atPath('label')
                ->addViolation();
                
        }
    }

}
