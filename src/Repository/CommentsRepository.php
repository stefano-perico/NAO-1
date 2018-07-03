<?php

namespace App\Repository;

use App\Entity\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Comments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comments[]    findAll()
 * @method Comments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Comments::class);
    }

    /**
     * @param null|string $term
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getCommentWithSearchQueryBuilder(?string $term): \Doctrine\ORM\QueryBuilder
    {
        $qb = $this->createQueryBuilder('a');

        if ($term) {
            $qb
                ->andWhere('a.title LIKE :term')
                ->setParameter('term','%' . $term . '%')
            ;
        }

        return $qb
            ->orderBy('a.id', 'ASC')
            ;
    }

}
