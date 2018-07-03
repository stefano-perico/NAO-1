<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function nameAndId():array
    {
        $usersInArray = [];
        foreach ($this->findAll() as $user) {
            $usersInArray[$user->getFirstName()] = $user;
        }
        return $usersInArray;
    }

    /**
     * @param null|string $term
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getUserWithSearchQueryBuilder(?string $term): \Doctrine\ORM\QueryBuilder
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
