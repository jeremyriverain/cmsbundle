<?php

namespace Geekco\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="Geekco\CmsBundle\Repository\TagRepository")
 * @UniqueEntity(fields={"categorie", "value"}, errorPath="value", message="Ce tag est déjà utilisé.")
 */
class Tag
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
    * @Assert\Length(max=100)
    * @Assert\NotBlank()
    * @ORM\Column(type="string", length=100)
    */
    private $value;

    /**
    * @var string
    * @Assert\Length(max=100)
    * @Assert\NotBlank()
    * @ORM\Column(type="string", length=100)
    */
    private $slug;

    /**
    * @var string
    * @Assert\Length(max=100)
    * @Assert\NotBlank()
    * @ORM\Column(type="string", length=100)
    */
    private $categorie;

    /**
    * @ORM\ManyToMany(targetEntity="Page", mappedBy="tags")
    */
    private $pages;

    public function __construct()
    {
        $this->pages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /*
     * Get id
     */
    public function getId()
    {
        return $this->id;
    }

    /*
     * Set value
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /*
     * Get value
     */
    public function getValue()
    {
        return $this->value;
    }

    /*
     * Get categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /*
     * Set categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
        return $this;
    }

    public function addPage(Page $page)
    {
        $this->pages[] = $page;

        return $this;
    }

    public function removePage(Page $page)
    {
        $this->pages->removeElement($page);
    }

    public function getPages()
    {
        return $this->pages;
    }

    /*
     * Get slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /*
     * Set slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }
}
