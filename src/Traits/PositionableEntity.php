<?php

namespace Geekco\CmsBundle\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait PositionableEntity
{
    /**
    * @var integer
    * @ORM\Column(type="integer")
    * @Assert\GreaterThanOrEqual(0)
    * @Assert\NotBlank()
    *
    */
    private $position = 0;

    /*
    * Get position
    * @return integer
    */
    public function getPosition()
    {
        return $this->position;
    }

    /*
    * Set position
    */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }
}
