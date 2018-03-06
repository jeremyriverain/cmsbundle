<?php

namespace Geekco\CmsBundle\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait LabelableEntity
{
    /**
    * @var string
    * @Assert\Length(max=255)
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $label;

    /*
     * Get label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /*
     * Set label
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }
}
