<?php

namespace Geekco\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Geekco\CmsBundle\Traits\LabelableEntity;
use Geekco\CmsBundle\Interfaces\ResourceInterface;
use Geekco\CmsBundle\Entity\Resource;

/**
 * StringResource
 *
 * @ORM\Table(name="string_resource")
 * @ORM\Entity(repositoryClass="Geekco\CmsBundle\Repository\StringResourceRepository")
 */
class StringResource implements ResourceInterface
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
    private $name = 'resource_string';

    /**
     * @var string
     * @Assert\Length(max=255)
     * @ORM\Column(name="value", type="string", nullable=true, length=255)
     */
    private $value;

    /**
    * @ORM\ManyToOne(targetEntity="Resource", inversedBy="stringResources")
    */
    private $resource;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $help;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    private $constraints = [];

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
     * @return StringResource
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
     * @return StringResource
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

    /*
     * Get help
     */
    public function getHelp()
    {
        return $this->help;
    }

    /*
     * Set help
     */
    public function setHelp($help)
    {
        $this->help = $help;
        return $this;
    }

    /*
     * Get constraints
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /*
     * Set constraints
     */
    public function setConstraints($constraints)
    {
        $this->constraints = $constraints;
        return $this;
    }
}
