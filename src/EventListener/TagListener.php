<?php
namespace Geekco\CmsBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Geekco\CmsBundle\Services\Slugify;
use Geekco\CmsBundle\Entity\Tag;

class TagListener
{
    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Tag) {
            return;
        }

        $slug = $this->slugify->slugify($entity->getValue());
        $entity->setSlug($slug);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Tag) {
            return;
        }

        $slug = $this->slugify->slugify($entity->getValue());
        $entity->setSlug($slug);
    }
}
