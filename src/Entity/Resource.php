<?php

namespace Geekco\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Geekco\CmsBundle\Traits\LabelableEntity;
use Geekco\CmsBundle\Entity\StringResource;
use Geekco\CmsBundle\Entity\TextResource;
use Geekco\CmsBundle\Entity\ImageResource;
use Geekco\CmsBundle\Entity\BooleanResource;
use Geekco\CmsBundle\Entity\IntegerResource;

/**
 * Resource
 *
 * @ORM\Table(name="resource")
 * @ORM\Entity(repositoryClass="Geekco\CmsBundle\Repository\ResourceRepository")
 */
class Resource
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
     * @ORM\OneToMany(targetEntity="StringResource", cascade={"persist", "remove"}, mappedBy="resource", orphanRemoval=true)
     * @Assert\Valid()
     */
    private $stringResources;

    /**
     * @ORM\OneToMany(targetEntity="TextResource", cascade={"persist", "remove"}, mappedBy="resource", orphanRemoval=true)
     * @Assert\Valid()
     */
    private $textResources;

    /**
     * @ORM\OneToMany(targetEntity="ImageResource", cascade={"persist", "remove"}, mappedBy="resource", orphanRemoval=true)
     * @Assert\Valid()
     */
    private $imageResources;

    /**
     * @ORM\OneToMany(targetEntity="BooleanResource", cascade={"persist", "remove"}, mappedBy="resource")
     * @Assert\Valid()
     */
    private $booleanResources;

    /**
     * @ORM\OneToMany(targetEntity="IntegerResource", cascade={"persist", "remove"}, mappedBy="resource")
     * @Assert\Valid()
     */
    private $integerResources;

    /**
     * @ORM\OneToMany(targetEntity="PageResource", mappedBy="resource", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $pageResources;

    /**
     * @ORM\OneToMany(targetEntity="ColorResource", cascade={"persist", "remove"}, mappedBy="resource")
     * @Assert\Valid()
     */
    private $colorResources;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    private $configuration = [];

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    private $compoundValue = [];

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stringResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->textResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->imageResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->booleanResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->integerResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pageResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->colorResources = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add stringResource
     *
     * @param \Geekco\CmsBundle\Entity\StringResource $stringResource
     *
     * @return Resource
     */
    public function addStringResource(StringResource $stringResource)
    {
        $this->stringResources[] = $stringResource;

        $stringResource->setResource($this);

        return $this;
    }

    /**
     * Remove stringResource
     *
     * @param \Geekco\CmsBundle\Entity\StringResource $stringResource
     */
    public function removeStringResource(StringResource $stringResource)
    {
        $this->stringResources->removeElement($stringResource);
        $stringResource->setResource(null);
    }

    /**
     * Get stringResources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStringResources()
    {
        return $this->stringResources;
    }

    /**
     * Add textResource
     *
     * @param \Geekco\CmsBundle\Entity\TextResource $textResource
     *
     * @return Resource
     */
    public function addTextResource(TextResource $textResource)
    {
        $this->textResources[] = $textResource;

        $textResource->setResource($this);

        return $this;
    }

    /**
     * Remove textResource
     *
     * @param \Geekco\CmsBundle\Entity\TextResource $textResource
     */
    public function removeTextResource(TextResource $textResource)
    {
        $this->textResources->removeElement($textResource);
    }

    /**
     * Get textResources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTextResources()
    {
        return $this->textResources;
    }

    public function addImageResource(ImageResource $imageResource)
    {
        $this->imageResources[] = $imageResource;
        $imageResource->setResource($this);
        return $this;
    }

    public function removeImageResource(ImageResource $imageResource)
    {
        $this->imageResources->removeElement($imageResource);
        $imageResource->setResource(null);
    }

    public function getImageResources()
    {
        return $this->imageResources;
    }

    public function addBooleanResource(BooleanResource $booleanResource)
    {
        $this->booleanResources[] = $booleanResource;
        $booleanResource->setResource($this);

        return $this;
    }

    public function removeBooleanResource(BooleanResource $booleanResource)
    {
        $this->booleanResources->removeElement($booleanResource);
    }

    public function getBooleanResources()
    {
        return $this->booleanResources;
    }

    public function addIntegerResource(IntegerResource $integerResource)
    {
        $this->integerResources[] = $integerResource;
        $integerResource->setResource($this);

        return $this;
    }

    public function removeIntegerResource(IntegerResource $integerResource)
    {
        $this->integerResources->removeElement($integerResource);
    }

    public function getIntegerResources()
    {
        return $this->integerResources;
    }


    public function addPageResource(PageResource $pageResource)
    {
        $this->pageResources[] = $pageResource;
        $pageResource->setResource($this);

        return $this;
    }

    public function removePageResource(PageResource $pageResource)
    {
        $this->pageResources->removeElement($pageResource);
    }

    public function getPageResources()
    {
        return $this->pageResources;
    }

    public function addColorResource(ColorResource $colorResource)
    {
        $this->colorResources[] = $colorResource;
        $colorResource->setResource($this);

        return $this;
    }

    public function removeColorResource(ColorResource $colorResource)
    {
        $this->colorResources->removeElement($colorResource);
    }

    public function getColorResources()
    {
        return $this->colorResources;
    }



    /**
     * Set compoundValue
     *
     * @param array $compoundValue
     *
     * @return Resource
     */
    public function setCompoundValue($compoundValue)
    {
        $this->compoundValue = $compoundValue;

        return $this;
    }

    /**
     * Get compoundValue
     *
     * @return array
     */
    public function getCompoundValue()
    {
        return $this->compoundValue;
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
}
