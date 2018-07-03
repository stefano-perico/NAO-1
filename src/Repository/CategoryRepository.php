<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function nameAndId():array
    {
        $categoriesInArray = [];
        foreach ($this->findAll() as $category) {
            $categoriesInArray[$category->getName()] = $category;
        }
        return $categoriesInArray;
    }

    /**
     * @param null|string $term
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getCategoryWithSearchQueryBuilder(?string $term): \Doctrine\ORM\QueryBuilder
    {
        $qb = $this->createQueryBuilder('a');

        if ($term) {
            $qb
                ->andWhere('a.title LIKE :term')
                ->setParameter('term','%' . $term . '%')
            ;
        }

        return $qb
            ->orderBy('a.id', 'DESC')
            ;
    }

}
