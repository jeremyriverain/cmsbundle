<?php

namespace Geekco\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Geekco\CmsBundle\Entity\Module;
use Geekco\CmsBundle\Entity\MenuItem;

/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="Geekco\CmsBundle\Repository\PageRepository")
 * @UniqueEntity("name")
 */
class Page
{

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
    * @Assert\NotBlank()
    * @Assert\Length(max=255)
    * @ORM\Column(type="string", length=255, unique=true)
    */
    private $name;

	/**
	 * @ORM\Column(length=128, unique=true)
     * @Assert\Length(max=255)
	 */
	private $slug;

    /**
     * @ORM\OneToMany(targetEntity="Module", mappedBy="page", cascade={"remove"}, orphanRemoval=true, fetch="EAGER")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Assert\Valid()
    */
    private $modules;

    /**
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="page", cascade={"remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Assert\Valid()
    */
    private $menuItems;


    /**
    * @ORM\ManyToMany(targetEntity="Tag", inversedBy="pages")
    */
    private $tags;

    /**
    * @var \DateTime
    * @ORM\Column(type="datetime", nullable=true)
    */
    private $createdAt;

    public function __toString()
    {
        return ucfirst($this->name);
    }
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modules = new \Doctrine\Common\Collections\ArrayCollection();
        $this->menuItems = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
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

    /*
    * Set slug
    * @return Page
    */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

  	public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add module
     *
     * @param \Geekco\CmsBundle\Entity\Module $module
     *
     * @return Page
     */
    public function addModule(Module $module)
    {
        $this->modules[] = $module;

        return $this;
    }

    /**
     * Remove module
     *
     * @param \Geekco\CmsBundle\Entity\Module $module
     */
    public function removeModule(Module $module)
    {
        $this->modules->removeElement($module);
    }

    /**
     * Get modules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * Add menuItem
     *
     * @param \Geekco\CmsBundle\Entity\MenuItem $menuItem
     *
     * @return Page
     */
    public function addMenuItem(MenuItem $menuItem)
    {
        $this->menuItems[] = $menuItem;

        return $this;
    }

    /**
     * Remove menuItem
     *
     * @param \Geekco\CmsBundle\Entity\MenuItem $menuItem
     */
    public function removeMenuItem(MenuItem $menuItem)
    {
        $this->menuItems->removeElement($menuItem);
    }

    /**
     * Get menuItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenuItems()
    {
        return $this->menuItems;
    }
 
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
        $tag->removePage($this);
    }

    public function getTags()
    {
        return $this->tags;
    }


    /*
     * Get createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /*
     * Set createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
