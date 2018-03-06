<?php
namespace Geekco\CmsBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Geekco\CmsBundle\Entity\Page;
use Geekco\CmsBundle\Services\Slugify;

class PageListener
{
    private $slugify;

	public function __construct(Slugify $slugify)
	{
        $this->slugify = $slugify;
	}

	public function prePersist(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();

		if (!$entity instanceof Page) {
			return;
		}

        $slug = $this->slugify->slugify($entity->getName());
        $entity->setSlug($slug);

        $entity->setCreatedAt(new \Datetime());
	}

	public function preUpdate(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();

		if (!$entity instanceof Page) {
			return;
		}

        $slug = $this->slugify->slugify($entity->getName());
        $entity->setSlug($slug);

	}
}
