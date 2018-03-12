<?php

namespace Geekco\CmsBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use DeepCopy\DeepCopy;
use DeepCopy\Filter\Doctrine\DoctrineCollectionFilter;
use DeepCopy\Matcher\PropertyTypeMatcher;
use DeepCopy\Filter\KeepFilter;
use DeepCopy\Matcher\PropertyMatcher;
use Geekco\CmsBundle\Entity\Page;
use Geekco\CmsBundle\Entity\Module;
use Geekco\CmsBundle\Entity\ImageResource;
use Geekco\CmsBundle\Entity\PageResource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ModuleManager
 */
class ModuleManager
{
    private $em;

    private $pathFixturesImg;

    private $targetDir;

    public function __construct(EntityManagerInterface $em, $pathFixturesImg, $targetDir)
    {
        $this->em = $em;
        $this->pathFixturesImg = $pathFixturesImg;
        $this->targetDir = $targetDir;
    }

    public function copy(Module $module)
    {
        $copier = new DeepCopy();

        $copier->addFilter(new DoctrineCollectionFilter(), new PropertyTypeMatcher('Doctrine\Common\Collections\Collection'));
        $copier->addFilter(new KeepFilter(), new PropertyMatcher(PageResource::class, 'page'));


        $copy = $copier->copy($module);

        $copy->setIsBase(false);
        $copy->setPage(null);

        $copyImagesResources = $this->getImageResources($copy);

        if ($copyImagesResources)
        {
            foreach ($copyImagesResources as $i)
            {
                $this->handleImageResource($i);
            }
        }

        $this->processImageResourceOfChildren($copy);

        return $copy;
    }

    public function resetModule(Module $m)
    {
        $resource = $m->getResource();

        $imageResources = $resource->getImageResources();
        foreach ($imageResources as $i)
        {
            $resource->removeImageResource($i);
        }
        
        $collection = new ArrayCollection(
            array_merge(
                $resource->getStringResources()->toArray(), 
                $resource->getTextResources()->toArray()
            )
        );

        foreach ($collection as $c)
        {
            $c->setValue(null);  
        }


    }

    private function setPositionOf(Module $module)
    {
        $page = $module->getPage();
        $currentModules = $page->getModules();
        $maxPosition = 0;
        foreach ($currentModules as $m)
        {
            if($maxPosition < $m->getPosition()){
                $maxPosition = $m->getPosition();
            }
        }
        $module->setPosition($maxPosition + 1);
        return $module;
    }


    public function addModuleToPage(Module $module, Page $page)
    {
        if($module->getHasForm() === true) 
        {
            foreach ($page->getModules() as $m)
            {
                if ($m->getHasForm() === true)
                {
                    $error =  "Une page ne peut pas contenir plus d'un formulaire.";
                    break;

                }
            }
        }

        if($module->getOnlyOne() === true) 
        {
            foreach ($page->getModules() as $m)
            {
                if ($module->getName() === $m->getName())
                {    
                    $error = "Ce module existe déjà sur la page cible et a été configuré pour ne pas être ajouté plus d'1 fois sur la page.";
                    break;
                }
            }

        } 

        if (isset($error))
        {
            return $error;
        }
        else
        {

            $newModule = $this->copy($module);
            $newModule->setPage($page);

            $this->setPositionOf($newModule);

            return $newModule;
        }

    }

    public function getPotentialModules(Page $page)
    {
        $modulesPage = $page->getModules();

        $nameModulesNotAvailable = [];

        foreach ($modulesPage as $m)
        {
            if ($m->getOnlyOne() ===true)
            {
                $nameModulesNotAvailable[] = $m->getName();
            }
        }

        $options = ['isBase' => true, 'manageable' => true];

        foreach ($modulesPage as $m)
        {
            if ($m->getHasForm() === true)
            {
                $options['hasForm'] = false;
                break;
            }
        }

        $bases = $this->em->getRepository(Module::class)->findBy($options, ['name' => 'ASC']);

        $basesAvailable = [];
        foreach ($bases as $b)
        {
            if(!in_array($b->getName(), $nameModulesNotAvailable)){
                $basesAvailable[] = $b;
            }
        }
        return $basesAvailable;
    }

    private function handleImageResource(ImageResource $i)
    {
        $source = $this->pathFixturesImg.$i->getImage();
        if(file_exists($source)){
            $nameDestFile = uniqId().$i->getImage();
            $destFile = $this->targetDir."/".$nameDestFile;
            if (!copy($source, $destFile)) {
                return false;
            }
            else {
                $i->setImage($nameDestFile);
                return true;
            }
        }
        return false;
    }

    private function processImageResourceOfChildren(Module $c)
    {
        if($c->getChildren()->count() > 0) {
            foreach ($c->getChildren() as $m)
            {
                $mImagesResources = $this->getImageResources($m);
                if ($mImagesResources)
                {
                    foreach ($mImagesResources as $i)
                    {
                        $this->handleImageResource($i);
                    }
                }
            }
        }
    }

    private function getImageResources(Module $m){
        $resource = $m->getResource();
        if ($resource)
        {
            $imagesResources = $m->getResource()->getImageResources();

            if ($imagesResources->count() > 0)
            {
                return $imagesResources;
            }
            else
            {
                return false; 
            }
        }
        else
        {
            return false;    
        }
    }

}
