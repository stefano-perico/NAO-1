<?php

namespace App\Controller;


use App\Entity\Observation;
use App\Repository\TaxrefRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MapController
 * @package App\Controller
 * @Route("/carte")
 */
class MapController extends Controller
{
    /**
     * @Route(name="observation")
     */
    public function observation(TaxrefRepository $repository){
        $obs = $repository->findObs();
        return $this->render('views/map/obs.html.twig', ['obs' => $obs]);
    }

    /**
     * @Route("/{slug}", name="find")
     */
    public function find(EntityManagerInterface $em, $slug)
    {
        $repository = $em->getRepository(Observation::class);
        $obs = $repository->findBy([
            'species' => $slug
        ]);

        return $this->render('views/map/find.html.twig', [
            'obs' => $obs
        ]);
    }

}