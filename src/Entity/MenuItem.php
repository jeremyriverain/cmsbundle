<?php

namespace Geekco\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Geekco\CmsBundle\Traits\PositionableEntity;
use Geekco\CmsBundle\Entity\Page;
use Geekco\CmsBundle\Entity\Menu;

/**
 * MenuItem
 *
 * @ORM\Table(name="menu_item")
 * @ORM\Entity(repositoryClass="Geekco\CmsBundle\Repository\MenuItemRepository")
 */
class MenuItem
{
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
    * @ORM\ManyToOne(targetEntity="Page", inversedBy="menuItems")
    * @ORM\JoinColumn(nullable=false)
    */
    private $page;

    /**
    * @ORM\ManyToOne(targetEntity="Menu", inversedBy="items")
    * @ORM\JoinColumn(nullable=false)
    */
    private $menu;

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
     * Set page
     *
     * @param \Geekco\CmsBundle\Entity\Page $page
     *
     * @return MenuItem
     */
    public function setPage(Page $page)
    {
        $this->page = $page;
        $page->addMenuItem($this);

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

    /**
     * Set menu
     *
     * @param \Geekco\CmsBundle\Entity\Menu $menu
     *
     * @return MenuItem
     */
    public function setMenu(Menu $menu)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Geekco\CmsBundle\Entity\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
