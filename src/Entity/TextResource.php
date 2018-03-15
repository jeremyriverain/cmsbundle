<?php

namespace Geekco\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Geekco\CmsBundle\Traits\LabelableEntity;
use Geekco\CmsBundle\Interfaces\ResourceInterface;

/**
 * TextResource
 *
 * @ORM\Table(name="text_resource")
 * @ORM\Entity(repositoryClass="Geekco\CmsBundle\Repository\TextResourceRepository")
 */
class TextResource implements ResourceInterface
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
    private $name = 'resource_text';

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text", nullable=true)
     */
    private $value;

    /**
    * @ORM\ManyToOne(targetEntity="Resource", inversedBy="textResources")
    */
    private $resource;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isHtml = false;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    private $configuration = [];

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
     * @return TextResource
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
     * @return TextResource
     */
    public function setResource(Resource $resource = null)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return \Geekco\CmsBundle\Entity\Resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /*
     * Get isHtml
     */
    public function getIsHtml()
    {
        return $this->isHtml;
    }

    /*
     * Set isHtml
     */
    public function setIsHtml($isHtml)
    {
        $this->isHtml = $isHtml;
        return $this;
    }

    /*
     * Get configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /*
     * Set configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
        return $this;
    }
}
