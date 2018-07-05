<?php
/**
 * Created by PhpStorm.
 * User: stefano
 * Date: 25/06/18
 * Time: 12:18
 */

namespace App\Controller;




use App\Repository\ArticleRepository;
use App\Repository\EventRepository;
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
     * @Route("/autocomplete_species", name="species_autocomplete")
     */
    public function autocompleteSpeciesAction(Request $request, TaxrefRepository $repository)
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

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/autocomplete_article", name="article_autocomplete")
     */
    public function autocompleteArticleAction(Request $request, ArticleRepository $repository)
    {
        $articles = [];
        $term = trim(strip_tags($request->get('term')));

        $entities = $repository->findArticle($term);

        foreach ($entities as $entity)
        {
            $articles[] = $entity->gettitle();
        }

        $response = new JsonResponse();
        $response->setData($articles);

        return $response;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/autocomplete_event", name="event_autocomplete")
     */
    public function autocompleteEventAction(Request $request, EventRepository $repository)
    {
        $events = [];
        $term = trim(strip_tags($request->get('term')));

        $entities = $repository->findEvent($term);

        foreach ($entities as $entity)
        {
            $events[] = $entity->getTitle();
        }

        $response = new JsonResponse();
        $response->setData($events);

        return $response;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/autocomplete_species_index", name="species_autocomplete_index")
     */
    public function autocompleteSpeciesIndexAction(Request $request, TaxrefRepository $repository)
    {
        $species = [];
        $term = trim(strip_tags($request->get('term')));

        $entities = $repository->findSpecies($term);

        foreach ($entities as $entity)
        {
            $species[] = $entity->getNomFr();
        }

        $response = new JsonResponse();
        $response->setData($species);

        return $response;
    }

}