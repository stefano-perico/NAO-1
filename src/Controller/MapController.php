<?php
/**
 * Created by PhpStorm.
 * User: stefano
 * Date: 24/06/18
 * Time: 09:52
 */

namespace App\Controller;


use App\Entity\Observation;
use App\Repository\TaxrefRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MapController
 * @package App\Controller
 * @Route("/map")
 */
class MapController extends Controller
{
    /**
     * @Route("/obs", name="obs")
     */
    public function obs(TaxrefRepository $repository){
        $obs = $repository->findObs();
        return $this->render('views/map/obs.html.twig', ['obs' => $obs]);
    }

    /**
     * @Route("/find/{slug}", name="find")
     */
    public function find(EntityManagerInterface $em, $slug)
    {
        $repository = $em->getRepository(Observation::class);
        $obs = $repository->findBy([
            'species' => $slug
        ]);

        return $this->render('views/map/find.html.twig', ['obs' => $obs]);
    }

}