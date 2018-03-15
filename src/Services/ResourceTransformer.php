<?php

namespace Geekco\CmsBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Geekco\CmsBundle\Entity\Resource;
use Geekco\CmsBundle\Interfaces\ResourceInterface;

/**
 * ResourceTransformer
 */
class ResourceTransformer
{
    public function getArray(Resource $resource)
    {
        $collection = new ArrayCollection(
            array_merge(
                $resource->getStringResources()->toArray(),
                $resource->getTextResources()->toArray(),
                $resource->getImageResources()->toArray(),
                $resource->getBooleanResources()->toArray(),
                $resource->getIntegerResources()->toArray(),
                $resource->getPageResources()->toArray(),
                $resource->getColorResources()->toArray()
            )
        );

        $array = [];
        foreach ($collection as $c) {
            if (!$c instanceof ResourceInterface) {
                throw new \Exception("Resource Transformer: une entité de type ressource n'implémente pas ResourceInterface");
            }

            if ($c !== null) {
                $name = $c->getName();
                $value = $c->getValue();
                $array[$name] = $value;
            }
        }
        return $array;
    }
}
