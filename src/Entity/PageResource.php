<?php

namespace Geekco\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Geekco\CmsBundle\Traits\LabelableEntity;
use Geekco\CmsBundle\Interfaces\ResourceInterface;
use Geekco\CmsBundle\Entity\Resource;
use Geekco\CmsBundle\Entity\Page;

/**
 * PageResource
 *
 * @ORM\Table(name="page_resource")
 * @ORM\Entity(repositoryClass="Geekco\CmsBundle\Repository\PageResourceRepository")
 */
class PageResource implements ResourceInterface
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
    private $name = 'resource_page';

    /**
    * @var integer
    * @ORM\Column(type="integer")
    */
    private $value;

    /**
    * @ORM\ManyToOne(targetEntity="Page")
    */
    private $page;

    /**
    * @ORM\ManyToOne(targetEntity="Resource", inversedBy="pageResources")
    */
    private $resource;

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
     * Get value
     */
    public function getValue()
    {
        return $this->value;
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
     * Get page
     */
    public function getPage()
    {
        return $this->page;
    }

    /*
     * Set page
     */
    public function setPage(Page $page = null)
    {
        $this->page = $page;
        if ($page !== null)
        {
            $this->value = $page->getId();
        }
        else
        {
            $this->value = null;
        }
        return $this;
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


}
