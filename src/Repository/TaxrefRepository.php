<?php

namespace App\Repository;

use App\Entity\Taxref;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Taxref|null find($id, $lockMode = null, $lockVersion = null)
 * @method Taxref|null findOneBy(array $criteria, array $orderBy = null)
 * @method Taxref[]    findAll()
 * @method Taxref[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxrefRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Taxref::class);
    }

    public function findObs()
    {
        return $this->createQueryBuilder('taxref')
            ->andWhere('taxref.obsCount > :val')
            ->setParameter('val', 0)
            ->orderBy('taxref.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findSpecies($term)
    {
        return $this->createQueryBuilder('t')
            ->where('t.nom_fr LIKE :name')
            ->setParameter('name', '%'.$term.'%')
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return Taxref[] Returns an array of Taxref objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Taxref
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
