<?php

namespace Geekco\CmsBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class ImageResource extends Constraint
{
    public $message = "L'image n'a pas été renseignée.";
   
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
