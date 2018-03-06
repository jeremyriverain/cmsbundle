<?php

namespace Geekco\CmsBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Geekco\CmsBundle\Entity\Page;

class PageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Page::class);
    }
   
    public function getPageWithModules($slug)
    {
        $qb = $this
            ->createQueryBuilder('p')
            ->leftJoin('p.modules', 'm')
            ->addSelect('m')
            ->where('p.slug = :slug')
            ->setParameter('slug', $slug)
            ->orderBy('m.position', 'ASC')
            
            ;
        return $qb->getQuery()->getOneOrNullResult();
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('d')
            ->where('d.something = :value')->setParameter('value', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
