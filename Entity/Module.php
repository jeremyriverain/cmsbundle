<?php

namespace Geekco\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Geekco\CmsBundle\Validator\Constraints as GeekcoAssert;
use Geekco\CmsBundle\Traits\LabelableEntity;
use Geekco\CmsBundle\Entity\Module;
use Geekco\CmsBundle\Entity\Resource;
use Geekco\CmsBundle\Entity\Page;
use Geekco\CmsBundle\Traits\PositionableEntity;

/**
 * Module
 *
 * @ORM\Table(name="module")
 * @ORM\Entity(repositoryClass="Geekco\CmsBundle\Repository\ModuleRepository")
 * @GeekcoAssert\Module
 */
class Module
{
    use PositionableEntity;
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
    private $name;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Module", mappedBy="parent", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="children")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $parent;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBase = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $manageable = true;

    /**
     * @ORM\Column(type="boolean")
     */
    private $onlyOne = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasForm = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $areChildrenPositionable = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPositionableInThePage = true;

    /**
     * @ORM\Column(type="boolean")
     */
    private $creatorAble = false;

    /**
     * @var string
     * @Assert\Length(max=255)
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pathThemeRelative;

    /**
     * @ORM\OneToOne(targetEntity="Resource", cascade={"persist", "remove"})
     */
    private $resource;

    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="modules")
     * @Assert\Valid()
     */
    private $page;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    private $options;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deletable = true;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasCkeditorResource = false;

    public function __toString()
    {
        return ucfirst($this->name);
    }

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
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set description
     *
     * @param string $description
     *
     * @return Module
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add child
     *
     * @param \Geekco\CmsBundle\Entity\Module $child
     *
     * @return Module
     */
    public function addChild(Module $child)
    {
        $this->children[] = $child;
        $child->setParent($this);

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Geekco\CmsBundle\Entity\Module $child
     */
    public function removeChild(Module $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Geekco\CmsBundle\Entity\Module $parent
     *
     * @return Module
     */
    public function setParent(Module $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Geekco\CmsBundle\Entity\Module
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set isBase
     *
     * @param boolean $isBase
     *
     * @return Module
     */
    public function setIsBase($isBase)
    {
        $this->isBase = $isBase;

        return $this;
    }

    /**
     * Get isBase
     *
     * @return boolean
     */
    public function getIsBase()
    {
        return $this->isBase;
    }

    /**
     * Set manageable
     *
     * @param boolean $manageable
     *
     * @return Module
     */
    public function setManageable($manageable)
    {
        $this->manageable = $manageable;

        return $this;
    }

    /**
     * Get manageable
     *
     * @return boolean
     */
    public function getManageable()
    {
        return $this->manageable;
    }


    /**
     * Set onlyOne
     *
     * @param boolean $onlyOne
     *
     * @return Module
     */
    public function setOnlyOne($onlyOne)
    {
        $this->onlyOne = $onlyOne;

        return $this;
    }

    /**
     * Get onlyOne
     *
     * @return boolean
     */
    public function getOnlyOne()
    {
        return $this->onlyOne;
    }

    /*
     * Get hasForm
     */
    public function getHasForm()
    {
        return $this->hasForm;
    }

    /*
     * Set hasForm
     */
    public function setHasForm($hasForm)
    {
        $this->hasForm = $hasForm;
        return $this;
    }

    /*
     * Get areChildrenPositionable
     */
    public function getAreChildrenPositionable()
    {
        return $this->areChildrenPositionable;
    }

    /*
     * Set areChildrenPositionable
     */
    public function setAreChildrenPositionable($areChildrenPositionable)
    {
        $this->areChildrenPositionable = $areChildrenPositionable;
        return $this;
    }

    /*
     * Get creatorAble
     */
    public function getCreatorAble()
    {
        return $this->creatorAble;
    }

    /*
     * Set creatorAble
     */
    public function setCreatorAble($creatorAble)
    {
        $this->creatorAble = $creatorAble;
        return $this;
    }

    /**
     * Set pathThemeRelative
     *
     * @param string $pathThemeRelative
     *
     * @return Module
     */
    public function setPathThemeRelative($pathThemeRelative)
    {
        $this->pathThemeRelative = $pathThemeRelative;

        return $this;
    }

    /**
     * Get pathThemeRelative
     *
     * @return string
     */
    public function getPathThemeRelative()
    {
        return $this->pathThemeRelative;
    }

    /**
     * Set resource
     *
     * @param \Geekco\CmsBundle\Entity\Resource $resource
     *
     * @return Module
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

    /**
     * Set page
     *
     * @param \Geekco\CmsBundle\Entity\Page $page
     *
     * @return Module
     */
    public function setPage(Page $page = null)
    {
        $this->page = $page;
        if($page !== null) {
        $page->addModule($this);
        }

        return $this;
    }

    /**
     * Get page
     *
     * @return \Geekco\CmsBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /*
     * Get options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /*
     * Set options
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }


    /*
     * Get deletable
     */
    public function getDeletable()
    {
        return $this->deletable;
    }

    /*
     * Set deletable
     */
    public function setDeletable($deletable)
    {
        $this->deletable = $deletable;
        return $this;
    }

    /*
     * Get hasCkeditorResource
     */
    public function getHasCkeditorResource()
    {
        return $this->hasCkeditorResource;
    }

    /*
     * Set hasCkeditorResource
     */
    public function setHasCkeditorResource($hasCkeditorResource)
    {
        $this->hasCkeditorResource = $hasCkeditorResource;
        return $this;
    }

    /*
     * Get isPositionableInThePage
     */
    public function getIsPositionableInThePage()
    {
        return $this->isPositionableInThePage;
    }

    /*
     * Set isPositionableInThePage
     */
    public function setIsPositionableInThePage($isPositionableInThePage)
    {
        $this->isPositionableInThePage = $isPositionableInThePage;
        return $this;
    }
}
