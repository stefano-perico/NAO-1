<?php

namespace App\Repository;

use App\Entity\Taxref;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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
            ->getQuery()
            ->getResult()
            ;
    }

    public function findSpecies(?string $term)
    {
        return $this->createQueryBuilder('t')
            ->where('t.nom_fr LIKE :name')
            ->setParameter('name', '%'.$term.'%')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param null|string $term
     */
    public function getSpeciesObsWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->createQueryBuilder('t')
            ->andWhere('t.obsCount > :val')
            ->setParameter('val', 0);

            if ($term) {
                $qb
                    ->andWhere('t.obsCount > :val')
                    ->andWhere('t.nom_fr LIKE :term OR t.lb_nom LIKE :term OR t.famille LIKE :term')
                    ->setParameters(['val' => 0, 'term' => '%' . $term . '%'])
                ;
            }

        return $qb;
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
