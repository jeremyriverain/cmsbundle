<?php

namespace Geekco\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Geekco\CmsBundle\Validator\Constraints as GeekcoAssert;
use Geekco\CmsBundle\Interfaces\ResourceInterface;
use Geekco\CmsBundle\Entity\Resource;

/**
 * @ORM\Entity(repositoryClass="Geekco\CmsBundle\Repository\ImageResourceRepository")
 * @GeekcoAssert\ImageResource
 */
class ImageResource implements ResourceInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @var string
    * @Assert\Length(max=255)
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $name = 'resource_image';

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255)
    */
    private $image;

    /**
    * @Assert\File(
    * maxSize="20000k",
    * maxSizeMessage="Le fichier excède 20Mo.",
    * mimeTypes={"image/png", "image/jpeg", "image/jpg", "image/svg+xml", "image/gif"},
    * mimeTypesMessage= "formats autorisés: png, jpeg, jpg, svg, gif"
    * )
    */
    private $imageFile;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $temporaryFile;

    /**
    * @var \DateTime
    * @ORM\Column(type="datetime", nullable=true)
    */
    private $updatedAt;

    /**
    * @ORM\ManyToOne(targetEntity="Resource", inversedBy="imageResources")
    */
    private $resource;

    /*
     * Get image
     */
    public function getImage()
    {
        return $this->image;
    }

    /*
     * Set image
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }


    /*
     * Set imageFile
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
        $this->updatedAt = new \DateTime('now');
        return $this;
    }

    /*
     * Get imageFile
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /*
     * Get updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /*
     * Set updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /*
     * Get name
     */
    public function getName()
    {
        return $this->name;
    }

    /*
     * Set name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getValue()
    {
        return $this->getImage();
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
     * Get temporaryFile
     */
    public function getTemporaryFile()
    {
        return $this->temporaryFile;
    }

    /*
     * Set temporaryFile
     */
    public function setTemporaryFile($temporaryFile)
    {
        $this->temporaryFile = $temporaryFile;
        return $this;
    }


    /*
     * Get id
     */
    public function getId()
    {
        return $this->id;
    }
}
