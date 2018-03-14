<?php

namespace Geekco\CmsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class Module extends Constraint

{
    public $notPaginable = "Aucune page ne peut être associée à un module de base";
    public $labelNotFilled = "Le label est obligatoire.";

    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
