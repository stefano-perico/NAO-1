<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function nameAndId():array
    {
        $imagesInArray = [];
        foreach ($this->findAll() as $image) {
            $imagesInArray[$image->getImage()->getOriginalName()] = $image;
        }
        return $imagesInArray;
    }

    /**
     * @param null|string $term
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getImageWithSearchQueryBuilder(?string $term): \Doctrine\ORM\QueryBuilder
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
