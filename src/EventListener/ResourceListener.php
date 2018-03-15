<?php

namespace Geekco\CmsBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Geekco\CmsBundle\Entity\Resource;
use Geekco\CmsBundle\Services\ResourceTransformer;

/**
 * ResourceListener
 */
class ResourceListener
{
    private $resourceTransformer;

    public function __construct(ResourceTransformer $resourceTransformer)
    {
        $this->resourceTransformer = $resourceTransformer;
    }

    private function setCompoundValue(LifecycleEventArgs $args, Resource $entity)
    {
        $data = $this->resourceTransformer->getArray($entity);
        $em = $args->getEntityManager();
        $entity->setCompoundValue($data);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Resource) {
            return;
        }

        $this->setCompoundValue($args, $entity);
        $em = $args->getEntityManager();
        $em->flush();
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Resource) {
            return;
        }

        $changeSet = $args->getEntityManager()->getUnitOfWork()->getEntityChangeSet($entity);
        if (array_key_exists("compoundValue", $changeSet)) {
            return;
        }

        $this->setCompoundValue($args, $entity);
    }
}
