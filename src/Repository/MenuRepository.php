<?php

namespace Geekco\CmsBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Geekco\CmsBundle\Entity\Menu;

class MenuRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Menu::class);
    }
  
    public function getMenu($name)
    {
        $qb = $this
            ->createQueryBuilder('m')
            ->leftJoin('m.items', 'i')
            ->addSelect('i')
            ->where('m.name = :name')
            ->setParameter('name', $name)
                        ;
        return $qb->getQuery()->getOneOrNullResult();
        
    }

}
