<?php

namespace Geekco\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Geekco\CmsBundle\Traits\LabelableEntity;
use Geekco\CmsBundle\Interfaces\ResourceInterface;
use Geekco\CmsBundle\Entity\Resource;

/**
 * ColorResource
 *
 * @ORM\Table(name="color_resource")
 * @ORM\Entity(repositoryClass="Geekco\CmsBundle\Repository\ColorResourceRepository")
 */
class ColorResource implements ResourceInterface
{

    use LabelableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var string
    * @Assert\Length(max=255)
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $name = 'resource_color';

    /**
     * @var string
     * @ORM\Column(name="value", type="string", nullable=true, length=255)
     */
    private $value;

    /**
    * @ORM\ManyToOne(targetEntity="Resource", inversedBy="colorResources")
    */
    private $resource;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /*
    * Get name
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /*
    * Set name
    * @return object
    */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
 
    /**
     * Set value
     *
     * @param string $value
     *
     * @return ColorResource
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * Set resource
     *
     * @param \Geekco\CmsBundle\Entity\Resource $resource
     *
     * @return ColorResource
     */
    public function setResource(Resource $resource = null)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return \GeekcoBundle\Entity\Resource
     */
    public function getResource()
    {
        return $this->resource;
    }
}
