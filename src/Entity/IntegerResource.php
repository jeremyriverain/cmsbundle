<?php

namespace Geekco\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Geekco\CmsBundle\Traits\LabelableEntity;
use Geekco\CmsBundle\Interfaces\ResourceInterface;
use Geekco\CmsBundle\Entity\Resource;

/**
 * IntegerResource
 *
 * @ORM\Table(name="integer_resource")
 * @ORM\Entity(repositoryClass="Geekco\CmsBundle\Repository\IntegerResourceRepository")
 */
class IntegerResource implements ResourceInterface
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
    private $name = 'resource_integer';

    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="integer", nullable=true)
     */
    private $value;

    /**
    * @ORM\ManyToOne(targetEntity="Resource", inversedBy="integerResources")
    */
    private $resource;

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
     * @param integer $value
     *
     * @return IntegerResource
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    } 

    public function setResource(Resource $resource = null)
    {
        $this->resource = $resource;

        return $this;
    }

    public function getResource()
    {
        return $this->resource;
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
