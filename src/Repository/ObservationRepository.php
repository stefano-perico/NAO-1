<?php

namespace App\Repository;

use App\Entity\Observation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Observation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Observation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Observation[]    findAll()
 * @method Observation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObservationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Observation::class);
    }

    /**
     * @param null|string $term
     * @return QueryBuilder
     */
    public function getSpeciesObsWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->createQueryBuilder('o')
            ->innerJoin('o.species', 's');

        if ($term) {
            $qb
                ->andWhere('s.obsCount > :val')
                ->andWhere('s.nom_fr LIKE :term OR s.lb_nom LIKE :term OR s.famille LIKE :term')
                ->setParameters(['val' => 0, 'term' => '%' . $term . '%'])
            ;
        }
        return $qb;
    }

    public function getSpeciesWithTerm(?string $term)
    {
        $qb = $this->createQueryBuilder('o')
            ->innerJoin('o.species', 's')
            ->andWhere('s.nom_fr LIKE :term OR s.lb_nom LIKE :term OR s.famille LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->getQuery()
            ->getResult();

        $observations = [];
        foreach ($qb as $item) {
            $observations[$item->getSpecies()->getId()][] = $item;
        }

        $formatedObs = [];
        foreach ($observations as $item){
            $species = $this->find($item[0]->getId());

            $formatedObs[] = [
                'count' => count($item),
                'famille' => $species->getSpecies()->getFamille(),
                'lbNom' => $species->getSpecies()->getLbNom(),
                'nomFr' => $species->getSpecies()->getNomFr(),
                'id' => $species->getSpecies()->getId()];
        }
        return $formatedObs;
    }

    /**
     *
     */
    public function isValidateOb()
    {
        $qb = $this
            ->createQueryBuilder('observation')
            ->where('observation.checked = true')
            ->getQuery()
            ->getResult()
        ;

        $observations = [];
        foreach ($qb as $item) {
            $observations[$item->getSpecies()->getId()][] = $item;
        }

        $formatedObs = [];
        foreach ($observations as $item){
            $species = $this->find($item[0]->getId());

            $formatedObs[] = [
                'count' => count($item),
                'famille' => $species->getSpecies()->getFamille(),
                'lbNom' => $species->getSpecies()->getLbNom(),
                'nomFr' => $species->getSpecies()->getNomFr(),
                'id' => $species->getSpecies()->getId()];
        }

        return $formatedObs;
    }

}
