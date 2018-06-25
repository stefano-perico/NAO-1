<?php
/**
 * Created by PhpStorm.
 * User: stefano
 * Date: 25/06/18
 * Time: 12:18
 */

namespace App\Controller;




use App\Repository\TaxrefRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class Autocomplete extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/autocomplete", name="species_autocomplete")
     */
    public function autocompleteAction(Request$request, TaxrefRepository $repository)
    {
        $species = [];
        $term = trim(strip_tags($request->get('term')));

        $entities = $repository->findSpecies($term);

        foreach ($entities as $entity)
        {
            $species[] = $entity->getNomFr(). " ({$entity->getLbNom()})";
        }

        $response = new JsonResponse();
        $response->setData($species);

        return $response;
    }

}