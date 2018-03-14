<?php

namespace Geekco\CmsBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Geekco\CmsBundle\Entity\Module;

class ModuleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Module::class);
    }

    
    public function findByUniqueCriteria($array)
    {
        if ($array['isBase'] === false)
        {
            return [];
        }
        return $this->createQueryBuilder('d')
            ->where('d.name = :value')->setParameter('value', $array['name'])
            ->andwhere('d.isBase = :isBase')->setParameter('isBase', $array['isBase'])
            ->getQuery()
            ->getResult()
        ;
    }
    
}
