<?php
namespace Geekco\CmsBundle\Twig;

use Geekco\CmsBundle\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use Geekco\CmsBundle\Entity\Module;
use Geekco\CmsBundle\Services\Slugify;
use Geekco\CmsBundle\Services\FileUploader;

class TwigExtension extends \Twig_Extension
{
    private $em;

    private $slugify;

    private $image_directory_relative_path;

    private $targetDir;

    public function __construct(EntityManagerInterface $em, Slugify $slugify, $targetDir, $image_directory_relative_path)
    {
        $this->em = $em;
        $this->slugify = $slugify;
        $this->image_directory_relative_path = $image_directory_relative_path;
        $this->targetDir = $targetDir;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('menu', array($this, 'menuFunction')),
            new \Twig_SimpleFunction('findById', array($this, 'findByIdFunction')),
            new \Twig_SimpleFunction('findOneModuleByName', array($this, 'findOneModuleByNameFunction')),
        );
    }

    public function findOneModuleByNameFunction(string $name)
    {
        $module = $this->em->getRepository(Module::class)->findOneByName($name);
        return $module;
    }

    public function menuFunction($name)
    {
        $menu = $this->em->getRepository(Menu::class)->getMenu($name);
        return $menu;
    }

    public function findByIdFunction($namespace, $id)
    {
        $page= $this->em->getRepository($namespace)->find($id);
        if($page) {
            return $page;
        }
        else
        {
            return null;
        }

    }

    public function getFilters(){
        return array(
            new \Twig_SimpleFilter('dateFr', array($this, 'dateFrFilter')),
            new \Twig_SimpleFilter('slugify', array($this, 'slugifyFilter')),
            new \Twig_SimpleFilter('image', [$this, 'imageFilter']),
        );
    }

    public function imageFilter(string $filename, $filter = null)
    {
        if (mime_content_type($this->targetDir."/".$filename) === 'image/svg+xml' || $filter === null)
        {
            return $this->image_directory_relative_path."/".$filename;
        }
        else
        {
            return $this->image_directory_relative_path."/".$filter.$filename;
        }
    }

    public function slugifyFilter($text)
    {
        return $this->slugify->slugify($text);
    }

    public function dateFrFilter(\Datetime $datetime)
    {
        $months = [
            1 => 'janvier',
            2 => 'février',
            3 => 'mars',
            4 => 'avril',
            5 => 'mai',
            6 => 'juin',
            7 => 'juillet',
            8 => 'août',
            9 => 'septembre',
            10 => 'octobre',
            11 => 'novembre',
            12 => 'décembre'
        ];

        $day = $datetime->format('d');
        $month = $months[intval($datetime->format('m'), 10)];
        $year = $datetime->format('Y');
        return "$day $month $year";
    }



}
