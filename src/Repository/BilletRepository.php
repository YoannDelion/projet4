<?php

namespace App\Repository;

use App\Entity\Billet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Billet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Billet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Billet[]    findAll()
 * @method Billet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilletRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Billet::class);
    }

    /**
     * @param \DateTime $dateVisite
     * @return int
     */
    public function getNombreBillets(\DateTime $dateVisite) :int
    {
        return $this->createQueryBuilder('b')
            ->select('count(b)')
            ->andWhere('b.dateVisite = :dateVisite')
            ->setParameter('dateVisite', $dateVisite)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
}
