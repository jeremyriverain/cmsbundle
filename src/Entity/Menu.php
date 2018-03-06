<?php

namespace Geekco\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Geekco\CmsBundle\Traits\LabelableEntity;
use Geekco\CmsBundle\Traits\PositionableEntity;
use Geekco\CmsBundle\Entity\MenuItem;
use Geekco\CmsBundle\Entity\Menu;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Menu
 *
 * @ORM\Table(name="menu")
 * @ORM\Entity(repositoryClass="Geekco\CmsBundle\Repository\MenuRepository")
 */
class Menu
{
    use LabelableEntity;
    use PositionableEntity;

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
    * @var string
    * @Assert\NotBlank()
    * @ORM\Column(type="string", length=255)
    */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="menu", cascade={"persist", "remove"}, orphanRemoval=true)
    */
    private $items;

    /**
    * @ORM\ManyToOne(targetEntity="Menu", inversedBy="children", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="SET NULL")
    */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="parent")
    */
    private $children;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function addItem(MenuItem $item)
    {
        $this->items[] = $item;
        $item->setMenu($this);

        return $this;
    }

    public function removeItem(MenuItem $item)
    {
        $this->items->removeElement($item);
    }

    public function getItems()
    {
        return $this->items;
    }
    
    public function setParent(Menu $parent = null)
    {
        $this->parent = $parent;
        $parent->addChild($this);

        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function addChild(Menu $child)
    {
        $this->children[] = $child;

        return $this;
    }

    public function removeChild(Menu $child)
    {
        $this->children->removeElement($child);
    }

    public function getChildren()
    {
        return $this->children;
    }


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
