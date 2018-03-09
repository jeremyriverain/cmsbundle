<?php
namespace Geekco\CmsBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Geekco\CmsBundle\Entity\ImageResource;
use Geekco\CmsBundle\Services\FileUploader;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\File;
use Geekco\CmsBundle\Entity\Module;
use Geekco\CmsBundle\Services\ImageManager;

class ImageResourceListener
{
    private $uploader;

    private $imageManager;

    public function __construct(FileUploader $uploader, ImageManager $imageManager)
    {
        $this->uploader = $uploader;
        $this->imageManager = $imageManager;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof ImageResource) {
            return;
        }

        if($entity->getImageFile() !== null)
        {
        $fileName = $this->uploadFile($entity);
        $entity->setImage($fileName);
        }
        $entity->setTemporaryFile($entity->getImage());

        $this->imageManager->applyFilters($entity);

    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof ImageResource) {
            return;
        }
        $fileName = $this->uploadFile($entity);
        if($fileName)
        { 
            $entity->setImage($fileName);
            $this->deleteFile($entity->getTemporaryFile());
            $entity->setTemporaryFile($fileName);
            $this->imageManager->applyFilters($entity);
        }

    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof ImageResource) {
            return;
        }

        $fileName = $entity->getImage();
        if (!empty($fileName)) {
            if(file_exists($this->uploader->getTargetDir().'/'.$fileName)) {
                $entity->setImageFile( new File($this->uploader->getTargetDir().'/'.$fileName));
            }
        }
    }

    private function uploadFile($entity)
    {
        $file = $entity->getImageFile();

        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            return $fileName;
        }
        return false;
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof ImageResource) {
            return;
        }

        $this->deleteFile($entity->getImage());
    }

    private function deleteFile(string $fileName)
    {
        if (file_exists($this->uploader->getTargetDir()."/".$fileName) && is_file($this->uploader->getTargetDir()."/".$fileName))
        {    
            unlink($this->uploader->getTargetDir()."/".$fileName);

        }
        foreach ($this->imageManager->getScaleFilters() as $f)
        {
            if(file_exists($this->uploader->getTargetDir()."/".$f['prefix'].$fileName) && is_file($this->uploader->getTargetDir()."/".$fileName)) {
            unlink($this->uploader->getTargetDir()."/".$f['prefix'].$fileName);
        }
        }
    }


}
